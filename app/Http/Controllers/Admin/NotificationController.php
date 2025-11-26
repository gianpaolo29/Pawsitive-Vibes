<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Use Laravel's built-in notifications relation
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }
}
