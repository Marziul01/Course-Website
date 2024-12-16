<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnroll;
use Illuminate\Http\Request;
use App\Mail\UpdateProfileCode;
use App\Models\Order;
use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mpdf\Writer\BackgroundWriter;

class UserDashboardController extends Controller
{
    public static function userDashboard(){

        $enroll = CourseEnroll::where('user_id', Auth::user()->id )->with('courses')->get();

        return view('frontend.profile.userDashboard',[
            'enrolls' => $enroll,
            'orders' => Order::where('status', 2)->get(),
        ]);
    }
    public static function userorders(){

        return view('frontend.profile.userorders',[
            'orders' => Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
    public static function userprofile(){
        return view('frontend.profile.userProfile',[

        ]);
    }
    public static function userchangePass(){
        return view('frontend.profile.passUser',[

        ]);
    }
    public static function courseEnroll($title, $id){

        $access = CourseEnroll::where('course_id', $id)->where('user_id', Auth::user()->id)->first();

        if(is_null($access)){
            return back();
        }

        $course = Course::find($id);

        return view('frontend.course.courseEnroll',[
            'course' => $course,
        ]);
    }

    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();
        $emailChanged = false;

        // Check if the email has changed
        if ($request->email !== $user->email) {
            $emailChanged = true;
            $verificationCode = rand(100000, 999999);

            // Store the code in session for later verification
            session(['verification_code' => $verificationCode, 'new_email' => $request->email]);

            // Send verification email
            Mail::to($request->email)->send(new UpdateProfileCode($verificationCode));

            return response()->json(['emailChanged' => true, 'newEmail' => $request->email]);
        }

        // If email is not changed, update the profile directly
        $user->update([
            'name' => $request->name,
            'number' => $request->number
        ]);

        return response()->json(['emailChanged' => false]);
    }

    public function verifyEmailCode(Request $request)
    {
        $user = Auth::user();
        $verificationCode = session('verification_code');
        $newEmail = session('new_email');

        // Check if the entered code matches the session code
        if ($request->verification_code == $verificationCode) {
            // Update the user's email and other data
            $user->update([
                'email' => $newEmail,
                'name' => $request->name,
                'number' => $request->number
            ]);

            // Clear session data
            session()->forget(['verification_code', 'new_email']);

            return response()->json(['verified' => true]);
        }

        return response()->json(['verified' => false], 422);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed', // 'confirmed' looks for 'password_confirmation'
        ], [
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Return status code 422 for validation errors
        }

        // Update the user's password
        $user = auth()->user();
        $user->password = Hash::make($request->password); // Hash the password before saving
        $user->save();

        // Respond with success message
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!',
        ]);
    }

    public function sendPaymentRequest(Request $request, $userId)
    {
        $user = Auth::user();
        if($user->commission <= 0) {
            return response()->json(['success' => false, 'message' => 'Sorry, you cannot request a payment yet!']);
        }

        // Create a new payment request
        $paymentRequest = new PaymentRequest();
        $paymentRequest->user_id = $userId;
        $paymentRequest->pending = $user->commission; // Pending amount is the current commission
        $paymentRequest->save();

        // Return success response
        return response()->json(['success' => true, 'message'=> 'Payment request has been sent successfully!']);
    }


}
