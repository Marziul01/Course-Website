<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Course;
use App\Models\HomePage;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public static function index(){

        return view('frontend.home.home',[
            'courses' => Course::where('status', 1 )->orderBy('created_at', 'desc')->get(),
            'blogs' => Blog::where('status',1)->orderBy('created_at', 'desc')->get(),
            'home' => HomePage::find(1),
        ]);
    }

    public static function allCourse() {
        return view('frontend.home.allCourse',[
            'courses' => Course::where('status', 1 )->orderBy('created_at', 'desc')->get(),
            'categories' => Category::where('status',1)->get(),
        ]);
    }


}
