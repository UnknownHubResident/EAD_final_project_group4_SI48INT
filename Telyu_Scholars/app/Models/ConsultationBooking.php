<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mentor_id',
        'booking_date',
        'booking_time',
        'notes',
        'status',
    ];

    /**
     * Relationship with the Student (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the Mentor
     */
    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}