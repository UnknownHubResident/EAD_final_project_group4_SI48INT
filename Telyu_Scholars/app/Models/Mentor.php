<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'platform',
        'location',
        'working_days',
        'time_schedule',
        'specialty',
        'profile_image',
    ];

    public function bookings()
    {
        return $this->hasMany(ConsultationBooking::class);
    }
}