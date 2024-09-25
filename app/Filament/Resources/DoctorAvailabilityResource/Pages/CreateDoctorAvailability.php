<?php

namespace App\Filament\Resources\DoctorAvailabilityResource\Pages;

use App\Filament\Resources\DoctorAvailabilityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Support\Facades\Auth;
use App\Models\Slot;
use Illuminate\Support\Facades\Log;


class CreateDoctorAvailability extends CreateRecord
{
    protected static string $resource = DoctorAvailabilityResource::class;

    protected function afterCreate()
    {
        Log::info('afterCreate method called');
        $availability = $this->record;

        // Parse the date and time
        $startTime = Carbon::parse($availability->date . ' ' . $availability->start_time);
        $endTime = Carbon::parse($availability->date . ' ' . $availability->end_time);
        $slotDuration = intval($availability->slot_duration);
        $doctor_id = $availability->doctor_id;
        Log::info('Slot generation started', [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'slot_duration' => $slotDuration,
        ]);
        while ($startTime->lessThan($endTime)) {
            $slotEndTime = (clone $startTime)->addMinutes($slotDuration);

            if ($slotEndTime->greaterThan($endTime)) {
                break;
            }

            // Create a new slot
            Slot::create([
                'doctor_id' => $doctor_id,
                'availability_id' => $availability->id,
                'start_time' => $startTime->toDateTimeString(),
                'end_time' => $slotEndTime->toDateTimeString(),
                'is_booked'=>false,
            ]);
            Log::info('Slot created', [
                'start_time' => $startTime->toDateTimeString(),
                'end_time' => $slotEndTime->toDateTimeString(),
            ]);

            // Move to the next slot
            $startTime = $slotEndTime;
        }
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = Auth::id();
        $data['doctor_id'] = $userId;

        return $data;
    }
}
