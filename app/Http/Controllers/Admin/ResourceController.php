<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Resource;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    /** @return class-string<Resource> */
    private function resource(Request $request): string
    {
        $resource = $request->route()->defaults['resource'];

        abort_unless(auth()->user()->hasAnyRole($resource::$roles), 403);

        return $resource;
    }

    public function index(Request $request)
    {
        $r = $this->resource($request);
        $query = $r::query();

        if ($term = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($r, $term) {
                foreach ($r::$search as $col) {
                    $isTranslatable = in_array($col, (new $r::$model)->translatable ?? [], true);
                    if ($isTranslatable) {
                        foreach (array_keys(locales()) as $loc) {
                            $w->orWhere("{$col}->{$loc}", 'like', "%{$term}%");
                        }
                    } else {
                        $w->orWhere($col, 'like', "%{$term}%");
                    }
                }
            });
        }

        foreach ($r::filters() as $filter) {
            $value = $request->query($filter['name']);
            if ($value !== null && $value !== '') {
                $query->where($filter['name'], $value);
            }
        }

        if ($r::$tree) {
            $all = (clone $query)->orderBy('sort')->orderBy('id')->get();
            $items = $this->flatten($all, $r::$tree);
            $paginator = null;
        } else {
            if ($r::$sortable) {
                $query->orderBy('sort')->orderBy('id');
            } else {
                foreach ($r::$order as $col => $dir) {
                    $query->orderBy($col, $dir);
                }
            }
            $paginator = $query->paginate(20)->withQueryString();
            $items = $paginator->getCollection()->map(fn ($m) => [$m, 0]);
        }

        return view('admin.resource.index', compact('r', 'items', 'paginator'));
    }

    public function create(Request $request)
    {
        $r = $this->resource($request);
        abort_unless($r::$canCreate, 404);
        $model = new $r::$model;

        return view('admin.resource.form', ['r' => $r, 'model' => $model, 'extra' => $r::formData(null)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $r = $this->resource($request);
        abort_unless($r::$canCreate, 404);

        $model = new $r::$model;
        $this->save($request, $r, $model);

        return redirect($r::route('index'))->with('success', 'Məlumat yaradıldı.');
    }

    public function edit(Request $request, int $id)
    {
        $r = $this->resource($request);
        $model = $r::query()->findOrFail($id);

        return view('admin.resource.form', ['r' => $r, 'model' => $model, 'extra' => $r::formData($model)]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $r = $this->resource($request);
        $model = $r::query()->findOrFail($id);
        $this->save($request, $r, $model);

        return redirect($r::route('index'))->with('success', 'Dəyişikliklər saxlanıldı.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $r = $this->resource($request);
        $model = $r::query()->findOrFail($id);

        if (! $r::canDelete($model)) {
            return back()->with('error', 'Bu qeyd silinə bilməz.');
        }

        foreach ($r::fields() as $f) {
            if ($f['type'] === 'image') {
                ImageService::delete($model->{$f['name']});
            }
            if ($f['type'] === 'gallery') {
                foreach ((array) $model->{$f['name']} as $path) {
                    ImageService::delete($path);
                }
            }
        }

        ActivityLog::record('delete', $model, $r::$singular);
        $model->delete();

        return redirect($r::route('index'))->with('success', 'Məlumat silindi.');
    }

    public function toggle(Request $request, int $id): RedirectResponse
    {
        $r = $this->resource($request);
        $model = $r::query()->findOrFail($id);
        $model->update(['is_active' => ! $model->is_active]);
        ActivityLog::record('update', $model, $r::$singular.' ('.($model->is_active ? 'aktiv' : 'passiv').')');

        return back();
    }

    public function reorder(Request $request): JsonResponse
    {
        $r = $this->resource($request);
        abort_unless($r::$sortable, 404);

        $ids = array_values((array) $request->input('ids'));
        $table = (new $r::$model)->getTable();
        foreach ($ids as $i => $id) {
            \DB::table($table)->where('id', (int) $id)->update(['sort' => $i + 1]);
        }

        return response()->json(['ok' => true]);
    }

    /* ------------------------------------------------------------------ */

    private function flatten($all, string $parentCol): \Illuminate\Support\Collection
    {
        $byParent = $all->groupBy($parentCol);
        $out = collect();
        $walk = function ($parentId, $depth) use (&$walk, $byParent, $out) {
            foreach ($byParent->get($parentId, collect()) as $m) {
                $out->push([$m, $depth]);
                $walk($m->id, $depth + 1);
            }
        };
        $walk(null, 0);

        return $out;
    }

    private function rules(string $r, $model): array
    {
        $rules = [];
        foreach ($r::fields() as $f) {
            $name = $f['name'];
            $req = ! empty($f['required']);
            $extra = $f['rules'] ?? null;

            if (! empty($f['translatable'])) {
                $rules[$name] = ['nullable', 'array'];
                foreach (array_keys(locales()) as $loc) {
                    $rules["{$name}.{$loc}"] = [$req && $loc === config('app.fallback_locale') ? 'required' : 'nullable', 'string'];
                }

                continue;
            }

            $rules[$name] = match ($f['type']) {
                'toggle' => ['boolean'],
                'image' => [$req && ! $model->exists ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:8192'],
                'gallery' => ['nullable', 'array'],
                'number' => [$req ? 'required' : 'nullable', 'integer'],
                'email' => [$req ? 'required' : 'nullable', 'email', 'max:255'],
                'url' => [$req ? 'required' : 'nullable', 'string', 'max:500'],
                'datetime' => [$req ? 'required' : 'nullable', 'date'],
                'password' => [$model->exists || ! $req ? 'nullable' : 'required', 'string', 'min:8'],
                'select' => [$req ? 'required' : 'nullable'],
                default => [$req ? 'required' : 'nullable', 'string', 'max:'.($f['type'] === 'text' ? 500 : 200000)],
            };

            if ($extra) {
                $rules[$name] = array_merge($rules[$name], is_array($extra) ? $extra : explode('|', $extra));
            }
            if ($f['type'] === 'gallery') {
                $rules[$name.'_new'] = ['nullable', 'array'];
                $rules[$name.'_new.*'] = ['image', 'max:8192'];
            }
        }

        return $rules;
    }

    private function save(Request $request, string $r, $model): void
    {
        $validated = $request->validate($this->rules($r, $model));
        $data = [];
        $translations = [];
        $isNew = ! $model->exists;

        foreach ($r::fields() as $f) {
            $name = $f['name'];
            $type = $f['type'];

            if (! empty($f['virtual'])) {
                continue;
            }

            if (! empty($f['translatable'])) {
                $values = [];
                foreach (array_keys(locales()) as $loc) {
                    $v = $validated[$name][$loc] ?? null;
                    if ($type === 'richtext' && $v !== null && trim(strip_tags($v, '<img><iframe>')) === '') {
                        $v = null;
                    }
                    $values[$loc] = ($v === '' ? null : $v);
                }
                $translations[$name] = $values;

                continue;
            }

            switch ($type) {
                case 'toggle':
                    $data[$name] = $request->boolean($name);
                    break;
                case 'image':
                    $file = $request->file($name);
                    if ($file instanceof UploadedFile) {
                        ImageService::delete($model->{$name} ?? null);
                        $data[$name] = ImageService::store($file, $f['folder'] ?? 'uploads', $f['max_width'] ?? 1600);
                    } elseif ($request->boolean('remove_'.$name)) {
                        ImageService::delete($model->{$name} ?? null);
                        $data[$name] = null;
                    }
                    break;
                case 'gallery':
                    $kept = array_values(array_filter((array) $request->input($name.'_keep', [])));
                    foreach ((array) ($model->{$name} ?? []) as $old) {
                        if (! in_array($old, $kept, true)) {
                            ImageService::delete($old);
                        }
                    }
                    foreach ((array) $request->file($name.'_new', []) as $file) {
                        $kept[] = ImageService::store($file, $f['folder'] ?? 'uploads', $f['max_width'] ?? 1600);
                    }
                    $data[$name] = $kept ?: null;
                    break;
                case 'password':
                    if (! empty($validated[$name])) {
                        $data[$name] = $validated[$name];
                    }
                    break;
                case 'slug':
                    $value = trim((string) ($validated[$name] ?? ''));
                    if ($value === '' && isset($f['source'])) {
                        $value = (string) ($request->input($f['source'].'.az') ?? $request->input($f['source']));
                    }
                    $data[$name] = $this->uniqueSlug($r, Str::slug($value) ?: Str::random(8), $name, $model);
                    break;
                case 'number':
                    $data[$name] = ($validated[$name] ?? '') === '' ? ($f['default'] ?? 0) : (int) $validated[$name];
                    break;
                case 'datetime':
                    $data[$name] = ($validated[$name] ?? null) ?: null;
                    break;
                default:
                    $data[$name] = ($validated[$name] ?? null) === '' ? null : ($validated[$name] ?? null);
            }
        }

        $data = $r::beforeSave($data, $isNew ? null : $model, $request);

        // Nodes/pages without an explicit order go to the end of the list.
        if ($r::$sortable && $isNew && ! array_key_exists('sort', $data)) {
            $data['sort'] = ((int) $r::query()->max('sort')) + 1;
        }

        $model->fill($data);
        foreach ($translations as $name => $values) {
            $model->setTranslations($name, array_filter($values, fn ($v) => $v !== null));
        }
        $model->save();

        $r::afterSave($model, $request);
        ActivityLog::record($isNew ? 'create' : 'update', $model, $r::$singular);
    }

    private function uniqueSlug(string $r, string $base, string $column, $model): string
    {
        $slug = $base;
        $i = 2;
        while ((new $r::$model)->newQuery()
            ->where($column, $slug)
            ->when($model->exists, fn ($q) => $q->where('id', '!=', $model->id))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
