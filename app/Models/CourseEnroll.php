<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnroll extends Model
{
    use HasFactory;

    public function courses(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
