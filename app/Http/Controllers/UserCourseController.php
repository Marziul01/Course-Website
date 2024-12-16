<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Course;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    public static function course($title,$id){
        return view('frontend.course.course',[
            'course' => Course::where('id', $id)->where('slug', $title)->first(),
        ]);
    }

    
}
