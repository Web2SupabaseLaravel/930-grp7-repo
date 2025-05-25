<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Practitioner;
use Illuminate\Http\Request;
use App\Notifications\AppointmentStatusNotification;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->isPractitioner()) {
            $appointments = Appointment::with(['patient', 'practitioner', 'service'])->get();
        } else {
            $appointments = Appointment::with(['patient', 'practitioner', 'service'])
                ->where('patient_id', $user->id)
                ->get();
        }

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients      = User::where('role_id', Role::PATIENT)->get();
            $practitioners = Practitioner::with('user')->get();
        $services      = Service::all();

        return view('appointments.create', compact('patients', 'practitioners', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'practitioner_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'nullable|string',
        ]);

        $exists = Appointment::where('practitioner_id', $validated['practitioner_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['appointment_date' => 'This appointment slot is already booked.'])->withInput();
            
        }

        $status = $validated['status'] ?? 'scheduled';

        Appointment::create([
            'patient_id' => $validated['patient_id'],
            'practitioner_id' => $validated['practitioner_id'],
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => $status,
        ]);

        $user = User::find($validated['patient_id']);
        $user->notify(new AppointmentStatusNotification('Your appointment has been successfully booked on' . $validated['appointment_date'] . ' الساعة ' . $validated['appointment_time'] . '.'));

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }

    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'completed';
        $appointment->save();
        $appointment->patient->notify(new AppointmentStatusNotification('Your appointment has been confirmed on: ' . $appointment->appointment_date . ' الساعة ' . $appointment->appointment_time . '.'));
        return back()->with('success', 'The appointment has been confirmed.');
    }

    public function destroy($id)
    {
        Appointment::destroy($id);
        $appointment = Appointment::findOrFail($id);
        $appointment->patient->notify(new AppointmentStatusNotification('Your appointment has been cancelled on' . $appointment->appointment_date . ' الساعة ' . $appointment->appointment_time . '.'));
        $appointment->delete();

        return back()->with('success', 'The appointment has been cancelled.');

    }

    public function edit($id)
    {
        $appointment    = Appointment::findOrFail($id);
        $patients       = User::where('role_id', Role::PATIENT)->get();
        $practitioners  = User::where('role_id', Role::PRACTITIONER)->get();
        $services       = Service::all();

        return view('appointments.edit', compact('appointment', 'patients', 'practitioners', 'services'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $data = $request->validate([
            'patient_id' => 'sometimes|exists:users,id',
            'practitioner_id' => 'sometimes|exists:users,id',
            'service_id' => 'sometimes|exists:services,id',
            'appointment_date' => 'sometimes|date',
            'appointment_time' => 'sometimes',
            'status' => 'sometimes|string',
        ]);

        if (
            isset($data['practitioner_id']) ||
            isset($data['appointment_date']) ||
            isset($data['appointment_time'])
        ) {
            $practitionerId = $data['practitioner_id'] ?? $appointment->practitioner_id;
            $date = $data['appointment_date'] ?? $appointment->appointment_date;
            $time = $data['appointment_time'] ?? $appointment->appointment_time;

            $exists = Appointment::where('practitioner_id', $practitionerId)
                ->where('appointment_date', $date)
                ->where('appointment_time', $time)
                ->where('id', '!=', $appointment->id)
                ->exists();

            if ($exists) {
                return back()->withErrors(['appointment_date' => 'This appointment slot is already booked.'])->withInput();
            }
        }

        $appointment->update($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully!');
    }
}
