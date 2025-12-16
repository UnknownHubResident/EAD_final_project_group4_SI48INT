<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'title',
        'description',
        'amount',
        'deadline',
        'image',
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean'
    ];

    public function provider() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(StudentApplication::class);
    }

    public function getFormattedAmountAttribute()
{
    return 'Rp ' . number_format($this->amount, 0, ',', '.');
}
}
