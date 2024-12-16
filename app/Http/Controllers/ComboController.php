<?php

namespace App\Http\Controllers;

use App\Models\ComboOfferCourse;
use App\Models\ComboOffers;
use App\Models\Course;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public static function comboCourses(){
        return view('admin.course.combo',[
            'combos' => Course::where('combo',1)->where('status',1)->get(),
            'courses' => Course::where('combo',0)->where('status',1)->get(),
        ]);
    }

    public static function comboStore(Request $request){
        $request->validate([
            'image' => 'required',
            'title' => 'required|string',
            'courses' => 'required|array|min:2|max:4',  // Require 2 to 4 courses
            'price' => 'required|numeric|min:0',
        ]);

        // Create the combo offer
        $combo = new Course();
        $combo->combo = 1;
        $combo->title = $request->title;
        $combo->price = $request->price;
        $combo->sale_price = $request->sale_price;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $request->input('title') . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin-assets/courses/images/'), $imageName);
            $combo->image = 'admin-assets/courses/images/' . $imageName;
        }
        $combo->save();

        $courses = $request->input('courses');

        foreach($courses as $course){
            $offercourse = new ComboOfferCourse();
            $offercourse->combo_id = $combo->id;
            $offercourse->course_id = $course;
            $offercourse->save();
        }
        return redirect()->back()->with('success', 'Combo offer created successfully!');
    }

    public static function comboUpdate(Request $request, $id){

        $request->validate([
            'title' => 'required|string',
            'courses' => 'required|array|min:2|max:4',  // Require 2 to 4 courses
            'price' => 'required|numeric|min:0',
        ]);

        $combo = Course::findOrFail($id);
        $combo->title = $request->title;
        $combo->price = $request->price;
        $combo->sale_price = $request->sale_price;
        if ($request->hasFile('image')) {
            if ($combo->image && file_exists(public_path($combo->image))) {
                unlink(public_path($combo->image));
            }

            $image = $request->file('image');
            $imageName = $request->input('title') . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin-assets/courses/images/'), $imageName);
            $combo->image = 'admin-assets/courses/images/' . $imageName;
        }
        $combo->save();

        $offercourses = ComboOfferCourse::where('combo_offer_id', $id)->get();
        foreach($offercourses as $offercourse){
            $offercourse->delete();
        }

        $courses = $request->input('courses');

        foreach($courses as $course){
            $offercourse = new ComboOfferCourse();
            $offercourse->combo_id = $combo->id;
            $offercourse->course_id = $course;
            $offercourse->save();
        }

        return redirect()->back()->with('success', 'Combo offer updated successfully!');
    }

    public static function comboDestroy(Request $request, $id){
        $combo = Course::find($id);
        $combo->delete();

        return back()->with('success', 'Combo Offer Deleted Successfully');
    }
}
