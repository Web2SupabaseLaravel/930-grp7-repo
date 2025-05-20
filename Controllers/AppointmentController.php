<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
            $appointments = Appointment::with(['patient', 'practitioner', 'service','appointment date' , 'appointment time'])->get();

    return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
   
         public function store(Request $request)
    {
        $data = $request->validate([
            'patiant_id' => 'required|integer',
            'practitioner_id' => 'required|integer',
            'service_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|string',
        ]);
            $exists = Appointment::where('practitioner_id', $data['practitioner_id'])
        ->where('appointment_date', $data['appointment_date'])
        ->where('appointment_time', $data['appointment_time'])
        ->exists();

         if ($exists) {
             return response()->json([
            'error' => 'chosen date and time is already booked for this practitioner'
        ], 409); 
    }

        return Appointment::create($data);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id){
 
   
             return Appointment::with(['patient', 'practitioner', 'service' ,'appointment date' , 'appointment time'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());
        return $appointment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
    }
}
