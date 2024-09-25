<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();

        return view('appointments.index', compact('doctors'));
    }

    public function getAvailableDates(Request $request)
    {
        $doctorId = $request->doctor_id;

        $dates = Slot::where('doctor_id', $doctorId)
            ->where('is_booked', false)
            ->selectRaw('DATE(start_time) as date, COUNT(*) as slots_count')
            ->groupBy('date')
            ->get()
            ->map(function ($date) {
                return [
                    'date' => Carbon::parse($date->date)->format('Y-m-d'),
                    'slots_count' => $date->slots_count,
                ];
            });

        return response()->json($dates);
    }

    public function getAvailableSlots(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date = $request->date;

        $slots = Slot::where('doctor_id', $doctorId)
            ->whereDate('start_time', $date)
            ->where('is_booked', false)
            ->orderBy('start_time')
            ->get()
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
                ];
            });

        return response()->json($slots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:slots,id',
        ]);

        $slot = Slot::find($request->slot_id);

        if ($slot->is_booked) {
            return redirect()->back()->withErrors('Slot already booked.');
        }

        Appointment::create([
            'patient_id' => auth::id(),
            'slot_id' => $slot->id,
        ]);

        $slot->update(['is_booked' => true]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }
}
