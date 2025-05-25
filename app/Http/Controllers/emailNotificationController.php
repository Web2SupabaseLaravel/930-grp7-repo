<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class emailNotificationController extends Controller
{

    public function index()
    {
        return Notification::with('user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'message' => 'required|string',
            'sent_at' => 'nullable|date',
        ]);

        $notification = Notification::create($data);

        \Mail::to($notification->user->email)
            ->send(new \App\Mail\NotificationEmail($notification));

        return response()->json($notification, 201);
    }
    public function show(string $id)
    {
        $notification = Notification::with('user')->findOrFail($id);
        return $notification;
    }

    public function destroy(string $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return response()->json(null, 204);
    }
}
