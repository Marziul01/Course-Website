<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function modules(){
        return $this->hasMany(Module::class);
    }

    public function enroll(){
        return $this->hasMany(CourseEnroll::class);
    }

    public function comboCourses()
    {
        return $this->hasMany(ComboOfferCourse::class, 'combo_id');
    }
}
