<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $notification = auth()->user()->notifications->find($request->id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('app.notifications.index', ['notifications' => $notifications]);
    }
}
