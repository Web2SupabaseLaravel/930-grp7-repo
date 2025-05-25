<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Notifications\AppointmentStatusNotification;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:remind';
    protected $description = 'Send reminders to patients about their appointments tomorrow';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $appointments = Appointment::where('appointment_date', $tomorrow)
            ->where('status', 'confirmed')
            ->with('patient')
            ->get();

        foreach ($appointments as $appointment) {
            if ($appointment->patient) {
                $appointment->patient->notify(new AppointmentStatusNotification(
                    'تذكير: لديك موعد غدًا بتاريخ ' . $appointment->appointment_date . ' الساعة ' . $appointment->appointment_time . '.'
                ));
            }
        }
    }
}
