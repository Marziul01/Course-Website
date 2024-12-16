<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\FreeCourseUser;
use App\Mail\SendVerificationCode;
use Illuminate\Support\Facades\Mail;

class FreeCourseController extends Controller
{
    public function checkEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $name = $request->name;

        // Fetch site settings for the redirect link
        $siteSettings = SiteSetting::find(1);

        // Check if email exists in the 'users' table
        if (User::where('email', $email)->exists()) {
            return response()->json([
                'success' => true,
                'message' => 'Email found, redirecting...',
                'redirect_url' => $siteSettings->free_course
            ]);
        }

        if (FreeCourseUser::where('email', $email)->exists()) {
            return response()->json([
                'success' => true,
                'message' => 'Email found, redirecting...',
                'redirect_url' => $siteSettings->free_course
            ]);
        }

        $verification_code = rand(100000, 999999);
        session(['verification_code' => $verification_code]);


        Mail::to($email)->send(new SendVerificationCode($verification_code));

        return response()->json([
            'success' => false,
            'message' => 'Verification code sent to your email!',
            'email' => $email,
            'name' => $name
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        // Fetch site settings for the redirect link
        $siteSettings = SiteSetting::find(1);

        // Check if the code matches the session code
        if ($request->verification_code == session('verification_code')) {
            // Save to 'free_course_users' table
            FreeCourseUser::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Clear the session code after verification
            session()->forget('verification_code');

            return response()->json([
                'success' => true,
                'message' => 'Verification successful, redirecting...',
                'redirect_url' => $siteSettings->free_course
            ]);
        } else {
            return response()->json([
                'error' => 'Verification code is incorrect.'
            ]);
        }
    }

    public static function freeusers(){
        return view('admin.user.freeusers',[
            'users' => FreeCourseUser::all(),
        ]);
    }


}
