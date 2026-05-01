<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // عرض notifications
    public function index()
    {
        $notifications = Notification::with('appointment.patient')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // Mark as read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = 1;
        $notification->save();

        return redirect()->route('notifications.index');
    }
}
