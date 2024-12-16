<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Mail\ContactMail;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserBlogController extends Controller
{
    public static function blogs(){

        return view('frontend.home.blog',[
            'blogs' => Blog::where('status',1)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public static function blogsPage($title,$id){
        return view('frontend.home.blogPage',[
            'blog' => Blog::where('id', $id)->first(),
            'blogs' => Blog::where('status',1)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public static function contact(){
        return view('frontend.home.contact',[

        ]);
    }

    public function submit(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = SiteSetting::find(1);

        try {
            Mail::to($admin->email)->send(new ContactMail(
                $request->name,
                $request->phone,
                $request->email,
                $request->message
            ));

            return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send message.'], 500);
        }
    }
}
