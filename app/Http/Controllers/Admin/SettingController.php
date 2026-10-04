<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', ['groups' => config('site.settings'), 'values' => Setting::allValues()]);
    }

    public function update(Request $request)
    {
        foreach (config('site.settings') as $fields) {
            foreach ($fields as $f) {
                $key = $f['key'];

                if ($f['type'] === 'image') {
                    $request->validate([$key => ['nullable', 'image', 'max:8192']]);
                    if ($file = $request->file($key)) {
                        ImageService::delete(Setting::get($key));
                        Setting::put($key, ImageService::store($file, 'settings', 1200));
                    } elseif ($request->boolean('remove_'.$key)) {
                        ImageService::delete(Setting::get($key));
                        Setting::put($key, null);
                    }

                    continue;
                }

                if (! empty($f['translatable'])) {
                    $vals = [];
                    foreach (array_keys(locales()) as $loc) {
                        $vals[$loc] = (string) $request->input("{$key}.{$loc}", '');
                    }
                    Setting::put($key, $vals);
                } else {
                    Setting::put($key, (string) $request->input($key, ''));
                }
            }
        }

        ActivityLog::record('update', null, 'Sayt parametrləri');

        return back()->with('success', 'Parametrlər saxlanıldı.');
    }
}
