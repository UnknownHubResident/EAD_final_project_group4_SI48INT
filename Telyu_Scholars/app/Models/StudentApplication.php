<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplication extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        'user_id',
        'scholarship_id',
        'status',
        'student_number',
        'study_major',
        'year_batch',
        'degree_rank',
        'motivation_letter',
        'transcript_path',
        'student_id_path',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }
}
