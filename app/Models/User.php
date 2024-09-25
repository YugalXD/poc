<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function doctorAvailabilities()
    {
        return $this->hasMany(DoctorAvailability::class, 'doctor_id');
    }
    public function slots()
    {
        return $this->hasMany(Slot::class, 'doctor_id');
    }
    public function appointments()
    {
        if ($this->role === 'patient') {
            return $this->hasMany(Appointment::class, 'patient_id');
        } elseif ($this->role === 'doctor') {
            return $this->hasManyThrough(Appointment::class, Slot::class, 'doctor_id', 'slot_id', 'id', 'id');
        }
    }
}
