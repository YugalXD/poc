<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Slot extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'availability_id',
        'start_time',
        'end_time',
        'is_booked',
        'updated_at',
        'created_at',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function availability()
    {
        return $this->belongsTo(DoctorAvailability::class, 'availability_id');
    }
    protected $appends = ['formatted_start_time', 'formatted_end_time'];

    public function getFormattedStartTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('H:i');
    }

    public function getFormattedEndTimeAttribute()
    {
        return Carbon::parse($this->end_time)->format('H:i');
    }
}
