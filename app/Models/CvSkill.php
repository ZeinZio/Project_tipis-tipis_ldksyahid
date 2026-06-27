<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvSkill extends Model
{
    protected $fillable = [
        'user_id', 'name', 'level'
    ];
}
