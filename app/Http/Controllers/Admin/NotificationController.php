<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()      // built-in relationship from Notifiable trait
            ->latest()
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAllRead()
    {
        $user = auth()->user();

        // mark all unread as read for this user
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function markRead(DatabaseNotification $notification)
    {
        // make sure this notification belongs to the logged-in user
        if (
            $notification->notifiable_id !== auth()->id() ||
            $notification->notifiable_type !== get_class(auth()->user())
        ) {
            abort(403);
        }

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        if (request()->wantsJson()) {
            return response()->noContent();
        }

        return back();
    }
}
