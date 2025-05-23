<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Patient Management API",
 *     description="API documentation for managing patients, appointments, and roles."
 * )
 *
 * @OA\Tag(
 *     name="Patient",
 *     description="Endpoints for patient management"
 * )
 */

class PatientController extends Controller


{
   
    public function show(Request $request)
    {
       
        $patient = $request->user();

        return response()->json([
            'status' => 'success',
            'data' => $patient
        ]);
    }

 
    public function update(Request $request)
    {
        $patient = $request->user();

        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $patient->id,
          
        ]);

        $patient->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث بيانات المريض بنجاح',
            'data' => $patient
        ]);
    }
    public function appointments(Request $request)
{
    $user = $request->user();

    $past = $user->appointments()->where('date', '<', now())->get();
    $upcoming = $user->appointments()->where('date', '>=', now())->get();

    return response()->json([
        'past_appointments' => $past,
        'upcoming_appointments' => $upcoming,
    ]);
}
}
