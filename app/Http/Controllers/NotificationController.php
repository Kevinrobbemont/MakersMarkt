<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->with(['product', 'order'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notificatie gemarkeerd als gelezen');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Alle notificaties gemarkeerd als gelezen');
    }
}
