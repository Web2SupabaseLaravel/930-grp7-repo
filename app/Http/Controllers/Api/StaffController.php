<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    
    public function index()
    {
       
        $patients = User::whereHas('role', function ($query) {
            $query->where('name', 'patient');
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $patients
        ]);
    }

   
    public function update(Request $request, $id)
    {
        $patient = User::whereHas('role', function ($query) {
            $query->where('name', 'patient');
        })->findOrFail($id);

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
}
