@extends('layouts.app')

@section('content')
<div class="container px-4 py-8 mx-auto">
    <h1 class="mb-6 text-2xl font-bold">Dashboard</h1>

    <!-- Next Appointment Card -->
    @if(isset($nextAppointment) && $nextAppointment)
        <h2 class="mb-4 text-xl font-semibold">Next Appointment</h2>
        @include('components.appointment-card', ['appointment' => $nextAppointment])
    @else
        <div class="p-6 mb-6 bg-white rounded-lg shadow">
            <h2 class="mb-4 text-xl font-semibold">Next Appointment</h2>
            <p class="text-gray-700">You have no upcoming appointments.</p>
        </div>
    @endif

    <!-- Past Appointments -->
    <h2 class="mt-8 mb-4 text-xl font-semibold">Past Appointments</h2>
    @if(isset($pastAppointments) && $pastAppointments->count() > 0)
        @foreach($pastAppointments as $appointment)
            @include('components.appointment-card', ['appointment' => $appointment])
        @endforeach
    @else
        <div class="p-6 bg-white rounded-lg shadow">
            <p class="text-gray-700">You have no past appointments.</p>
        </div>
    @endif
</div>
@endsection
