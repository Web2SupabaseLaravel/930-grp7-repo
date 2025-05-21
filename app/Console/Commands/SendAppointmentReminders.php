<?php
// app/Console/Commands/SendAppointmentReminders.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminder;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:remind';
    protected $description = 'Send email reminders for tomorrow’s appointments';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        $appointments = Appointment::with(['patient','practitioner','service'])
            ->where('appointment_date', $tomorrow)
            ->where('status', 'scheduled')
            ->get();

        foreach ($appointments as $appt) {
            Mail::to($appt->patient->email)
                ->queue(new AppointmentReminder($appt));
        }

        $this->info('Reminders sent: '.$appointments->count());
    }
}
