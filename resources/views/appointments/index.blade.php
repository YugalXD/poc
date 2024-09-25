@extends('layouts.app')

@section('content')
<div class="container px-4 py-8 mx-auto" x-data="appointmentBooking()">
    <h1 class="mb-6 text-2xl font-bold">Book an Appointment</h1>

    @if(session('success'))
        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
        @csrf
        <div>
            <label for="doctor" class="block text-sm font-medium text-gray-700">Select a Doctor:</label>
            <select name="doctor_id" id="doctor" required
                class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                x-model="doctorId"
                @change="fetchAvailableDates">
                <option value="">-- Select Doctor --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Select a Date:</label>
            <template x-if="dates.length > 0">
                <select name="date" id="date" required
                    class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    x-model="selectedDate"
                    @change="fetchAvailableSlots">
                    <option value="">-- Select Date --</option>
                    <template x-for="date in dates" :key="date.date">
                        <option :value="date.date" x-text="`${date.date} (${date.slots_count} slots available)`"></option>
                    </template>
                </select>
            </template>
            <template x-if="dates.length === 0 && doctorId">
                <p class="text-gray-500">No available dates.</p>
            </template>
        </div>

        <div x-show="slots.length > 0" style="display: none;">
            <label for="slot" class="block text-sm font-medium text-gray-700">Select a Time Slot:</label>
            <select name="slot_id" id="slot" required
                class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">-- Select Time Slot --</option>
                <template x-for="slot in slots" :key="slot.id">
                    <option :value="slot.id" x-text="`${slot.start_time} - ${slot.end_time}`"></option>
                </template>
            </select>
        </div>

        <div x-show="slots.length === 0 && selectedDate" style="display: none;">
            <p class="text-gray-500">No available slots for this date.</p>
        </div>

        <div>
            <button type="submit"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Book Appointment
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Include your compiled app.js and app.css via Vite -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<script>
function appointmentBooking() {
    return {
        doctorId: '',
        dates: [],
        selectedDate: '',
        slots: [],

        fetchAvailableDates() {
            this.selectedDate = '';
            this.slots = [];

            if (this.doctorId) {
                fetch(`{{ route('appointments.dates') }}?doctor_id=${this.doctorId}`)
                    .then(response => response.json())
                    .then(data => {
                        this.dates = data;
                    })
                    .catch(error => {
                        console.error('Error fetching dates:', error);
                    });
            } else {
                this.dates = [];
            }
        },

        fetchAvailableSlots() {
            if (this.doctorId && this.selectedDate) {
                fetch(`{{ route('appointments.slots') }}?doctor_id=${this.doctorId}&date=${this.selectedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        this.slots = data;
                    })
                    .catch(error => {
                        console.error('Error fetching slots:', error);
                    });
            } else {
                this.slots = [];
            }
        }
    }
}
</script>
@endpush
