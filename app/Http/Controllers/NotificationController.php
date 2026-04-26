<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $notifications = auth()->user()->notifications()->latest()->get();

        auth()->user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}
