<div class="p-6 mb-6 bg-white rounded-lg shadow">
    <div class="flex items-center">
        <div class="flex-1">
            <p class="text-gray-700">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('Y-m-d') }}
            </p>
            <p class="text-gray-700">
                <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('H:i') }}
            </p>
            @if(auth()->user()->role === 'patient')
                <p class="text-gray-700">
                    <strong>Doctor:</strong> {{ $appointment->slot->doctor->name }}
                </p>
            @elseif(auth()->user()->role === 'doctor')
                <p class="text-gray-700">
                    <strong>Patient:</strong> {{ $appointment->patient->name }}
                </p>
            @endif
        </div>
    </div>
</div>
