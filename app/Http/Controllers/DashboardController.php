<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth::user();

        // Fetch appointments based on user role
        if ($user->role === 'patient') {
            $appointments = Appointment::with(['slot.doctor'])
                ->where('patient_id', $user->id)
                ->orderBy('slot.start_time', 'asc')
                ->get();

        } else {
            $appointments = collect(); // Empty collection for other roles
        }

        // Separate next appointment and past appointments
        $now = Carbon::now();

        $nextAppointment = $appointments->filter(function ($appointment) use ($now) {
            return Carbon::parse($appointment->slot->start_time)->greaterThanOrEqualTo($now);
        })->sortBy('slot.start_time')->first();

        $pastAppointments = $appointments->filter(function ($appointment) use ($now) {
            return Carbon::parse($appointment->slot->start_time)->lessThan($now);
        })->sortByDesc('slot.start_time');

        // Pass variables to the view
        return view('dashboard', [
            'nextAppointment' => $nextAppointment,
            'pastAppointments' => $pastAppointments,
        ]);
    }
}
