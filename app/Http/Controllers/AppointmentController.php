<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Appointments",
 *     description="API Endpoints for managing appointments"
 * )
 *
 * @OA\Schema(
 *     schema="Appointment",
 *     type="object",
 *     required={"patient_id","practitioner_id","service_id","appointment_date","appointment_time"},
 *     @OA\Property(property="patient_id", type="integer"),
 *     @OA\Property(property="practitioner_id", type="integer"),
 *     @OA\Property(property="service_id", type="integer"),
 *     @OA\Property(property="appointment_date", type="string", format="date"),
 *     @OA\Property(property="appointment_time", type="string", format="time"),
 *     @OA\Property(property="status", type="string")
 * )
 */

class AppointmentController extends Controller
{
    
public function bookingPage(Request $request)
{
    $patiantId = $request->query('patiant_id');
    $myAppointments = collect();

    if ($patiantId) {
        $myAppointments = \App\Models\Appointment::with(['practitioner', 'service'])
            ->where('patiant_id', $patiantId)
            ->get();
    }

    return view('appointments', compact('myAppointments'));
}

public function confirm($id)
{
    $appointment = \App\Models\Appointment::findOrFail($id);
    $appointment->status = 'confirmed';
    $appointment->save();

    return back()->with('success', 'Your reservation is confirmed!');
}


    /**
     * @OA\Get(
     *     path="/api/appointments",
     *     summary="Get all appointments",
     *     tags={"Appointments"},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'practitioner', 'service','appointmentDate', 'appointmentTime'])->get();
        return response()->json($appointments);
    }

    /**
     * @OA\Post(
     *     path="/api/appointments",
     *     summary="إنشاء موعد جديد",
     *     tags={"Appointments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="تم إنشاء الموعد بنجاح",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(response=409, description="Chosen date and time is already booked")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|integer',
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

        $appointment = Appointment::create($data);

        return response()->json($appointment, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/appointments/{id}",
     *     summary="Get appointment by ID",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the appointment",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response - Appointment data",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(response=404, description="Appointment not found")
     * )
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(['patient', 'practitioner', 'service', 'appointmentDate', 'appointmentTime'])->findOrFail($id);
        return response()->json($appointment);
    }

    /**
     * @OA\Put(
     *     path="/api/appointments/{id}",
     *     summary="Update an existing appointment",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Appointment ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(response=404, description="Appointment not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = $request->validate([
            'patient_id' => 'integer',
            'practitioner_id' => 'integer',
            'service_id' => 'integer',
            'appointment_date' => 'date',
            'appointment_time' => 'string',
            'status' => 'string',
        ]);

        $appointment->update($data);

        return response()->json($appointment);
    }

    /**
     * @OA\Delete(
     *     path="/api/appointments/{id}",
     *     summary="Delete an appointment",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Appointment ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Appointment deleted successfully"),
     *     @OA\Response(response=404, description="Appointment not found")
     * )
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(null, 204);
    }
}
