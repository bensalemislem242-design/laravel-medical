<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationApiController extends Controller
{
    // تجيب كل notifications
    public function index(Request $request)
    {
        $notifications = Notification::with(['appointment.doctor.specialty', 'appointment.hospital', 'appointment.patient'])
            ->where('user_id', $request->user()->id) // notifications للمستخدم المتصل فقط
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    // تفاصيل notification واحدة
    public function show($id)
    {
        $notification = Notification::with(['appointment.doctor.specialty', 'appointment.hospital', 'appointment.patient'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'notification' => $notification
        ]);
    }
}
