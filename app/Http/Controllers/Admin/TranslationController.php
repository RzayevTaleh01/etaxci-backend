<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $rows = Translation::query()
            ->when($q, fn ($w) => $w->where('key', 'like', "%$q%")->orWhere('text', 'like', "%$q%"))
            ->orderBy('key')->get();

        return view('admin.translations', compact('rows', 'q'));
    }

    public function update(Request $request)
    {
        foreach ((array) $request->input('t', []) as $id => $texts) {
            $clean = [];
            foreach (array_keys(locales()) as $loc) {
                $clean[$loc] = (string) ($texts[$loc] ?? '');
            }
            Translation::where('id', $id)->update(['text' => json_encode($clean, JSON_UNESCAPED_UNICODE)]);
        }
        Translation::flush();
        ActivityLog::record('update', null, 'İnterfeys tərcümələri');

        return back()->with('success', 'Tərcümələr saxlanıldı.');
    }
}
