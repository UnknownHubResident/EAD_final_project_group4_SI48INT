<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    //
    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class);
    }

}
