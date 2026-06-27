<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvExperience extends Model
{
    protected $fillable = [
        'user_id', 'company', 'position', 
        'start_date', 'end_date', 'is_current', 'description'
    ];
}
