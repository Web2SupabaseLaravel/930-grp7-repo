<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentCancelled;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'practitioner', 'service']);

        if ($request->filled('practitioner_id')) {
            $query->where('practitioner_id', $request->practitioner_id);
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }
        if ($request->filled('date')) {
            $query->where('appointment_date', $request->date);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id'       => 'required|exists:users,id',
            'practitioner_id'  => 'required|exists:practitioners,id',
            'service_id'       => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        $exists = Appointment::where([
            'practitioner_id'  => $data['practitioner_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
        ])->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'appointment_time' => ['This appointment is pre-booked.'],
            ]);
        }

        $appointment = Appointment::create($request->all());
        $appointment->load('user', 'doctor');

        Mail::to($appointment->user->email)->send(new AppointmentConfirmed($appointment));

        return redirect()->route('appointments.index')
                         ->with('success', 'The appointment was created successfully.');

    }

    public function show($id)
    {
        return Appointment::with(['patient', 'practitioner', 'service'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = $request->validate([
            'appointment_date' => 'sometimes|date|after_or_equal:today',
            'appointment_time' => 'sometimes|date_format:H:i',
            'status'           => 'sometimes|in:scheduled,cancelled,completed',
        ]);

        if (isset($data['appointment_date']) || isset($data['appointment_time'])) {
            $newDate = $data['appointment_date'] ?? $appointment->appointment_date;
            $newTime = $data['appointment_time'] ?? $appointment->appointment_time;

            $conflict = Appointment::where('practitioner_id', $appointment->practitioner_id)
                ->where('appointment_date', $newDate)
                ->where('appointment_time', $newTime)
                ->where('id', '<>', $appointment->id)
                ->exists();

            if ($conflict) {
                throw ValidationException::withMessages([
                    'appointment_time' => ['The new date conflicts with an existing date.'],
                ]);
            }
        }

        $oldStatus = $appointment->status;
        $appointment->update($request->all());
        $appointment->load('user', 'doctor');



         return redirect()->route('appointments.index')
                         ->with('success', 'The appointment has been updated successfully.');

    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

    }
}
