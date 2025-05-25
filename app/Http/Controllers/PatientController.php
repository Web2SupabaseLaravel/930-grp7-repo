<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
 
    public function myAppointments()
    {
        $user = Auth::user();

        $appointments = Appointment::where('user_id', $user->id)
            ->orderBy('appointment_at', 'desc')
            ->get();

        $now = now();
        $upcoming = $appointments->where('appointment_at', '>=', $now)->values();
        $past = $appointments->where('appointment_at', '<', $now)->values();

        return response()->json([
            'upcoming' => $upcoming,
            'past' => $past
        ]);
    }

    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'contact_info' => 'nullable|string',
            'insurance_info' => 'nullable|string',
        ]);

        $user->update($data);

        return response()->json(['message' => 'Profile updated', 'user' => $user]);
    }
}
