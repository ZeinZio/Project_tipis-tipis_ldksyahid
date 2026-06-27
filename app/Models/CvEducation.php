<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvEducation extends Model
{
    protected $table = 'cv_educations';
    
    protected $fillable = [
        'user_id', 'institution', 'degree', 'field_of_study', 
        'start_date', 'end_date', 'is_current', 'description'
    ];
}
