<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Practitioner;
use App\Models\Service;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
         if (auth()->user()->role->name !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

        $totalUsers         = User::count();
        $totalPractitioners = Practitioner::count();
        $totalServices      = Service::count();
        $totalAppointments  = Appointment::count();
        $todayAppointments  = Appointment::whereDate('created_at', now()->toDateString())->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPractitioners',
            'totalServices',
            'totalAppointments',
            'todayAppointments'
        ));
    }
}
