<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->get();
        return $this->result(200, 'get Notifications Successfully', $notifications);
    }
    public function unreadCount(Request $request)
    {
        return response()->json([
            'code' => 200,
            'unread_count' => $request->user()->unreadNotifications()->count()
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return $this->result(200, 'Notification marked as read', $notification);
        }
        return $this->result(404, 'Notification not found');
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return $this->result(200, 'All notifications marked as read');
    }
}
