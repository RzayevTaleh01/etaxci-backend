<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::query()
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($request->query('q'), fn ($q, $t) => $q->where(fn ($w) => $w
                ->where('first_name', 'like', "%$t%")
                ->orWhere('last_name', 'like', "%$t%")
                ->orWhere('email', 'like', "%$t%")
                ->orWhere('message', 'like', "%$t%")))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function status(Request $request, ContactMessage $message)
    {
        $message->update(['status' => $request->validate(['status' => 'required|in:new,read,answered'])['status']]);

        return back()->with('success', 'Status yeniləndi.');
    }

    public function destroy(ContactMessage $message)
    {
        ActivityLog::record('delete', $message, 'Müraciət');
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Müraciət silindi.');
    }
}
