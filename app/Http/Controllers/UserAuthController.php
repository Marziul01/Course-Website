<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Country;
use App\Models\Profile;
use App\Models\Upazila;
use App\Models\Category;
use App\Models\District;
use App\Models\UserInfo;
use App\Models\UserPlan;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationCode;
use App\Mail\VerificationMail;
use Illuminate\Support\Carbon;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Mail\PasswordResetCodeMail;
use App\Mail\ResetPasswordCodeMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\String\b;
use Laravel\Socialite\Facades\Socialite;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewUserNotification;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;


class UserAuthController extends Controller
{
    private static $auth;

    public function sendVerificationCode(Request $request)
    {
        // Validate the registration form input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone'  => 'required|unique:users,number',
            'email'  => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate a 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Store user data temporarily in the session or cache
        $userData = $request->only(['name', 'email', 'phone', 'password']);
        Cache::put('register_user_' . $userData['email'], $userData, now()->addMinutes(10));
        Cache::put('verification_code_' . $userData['email'], $verificationCode, now()->addMinutes(10));

        // Send the verification code via email
        Mail::to($userData['email'])->send(new VerificationCode($verificationCode));

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your email.',
            'email' => $request->email,
        ]);
    }


    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verification_code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $storedCode = Cache::get('verification_code_' . $request->email);

        // Check if the code matches
        if ($storedCode != $request->verification_code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code.'
            ], 422);
        }

        // Retrieve stored user data
        $userData = Cache::get('register_user_' . $request->email);

        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'User registration data not found or expired. Please register again.'
            ], 422);
        }

        // Create the user
        $user = new User;
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->number = $userData['phone'];
        $user->password = Hash::make($userData['password']);
        $user->save();

        // Log the user in
        Auth::login($user);

        // Clear cache after successful registration
        Cache::forget('register_user_' . $request->email);
        Cache::forget('verification_code_' . $request->email);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'redirect' => route('user.dashboard')
        ]);
    }


    public function signUp(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You are already logged in.',
            ], 422);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'role' => 'nullable',
            'name' => 'required|string|max:255',
            'phone'  => 'required|unique:users,number',
            'email'  => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'affiliate_link' => 'nullable|required_if:role,affiliate',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors() // Return validation errors
            ], 422);
        }

        // Create the user
        $user = new User;
        $user->role = 0;
        if (!is_null($request->role)) {
            $user->role_name = $request->role;
            $user->affiliate_link = $request->affiliate_link;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        // Log the user in
        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => route('user.dashboard')
        ]);
    }



    public function verifyEmailCode(Request $request)
    {
        $verificationCode = session('verification_code');

        if ($request->code == $verificationCode) {

            $userData = session('user_data');
            $password = session('password');

            // Create new user
            $user = new User;
            $user->role = 0;
            $user->name = $userData['first_name'] . ' ' . $userData['last_name'];
            $user->email = $userData['email'];
            $user->password = $password;
            $user->save();

            // Assign default user plan
            $plan = new UserPlan();
            $plan->user_id = $user->id;
            $plan->plan_id = 1;
            $plan->start_date = now();
            $plan->end_date = null;
            $plan->save();

            // Log the user in
            Auth::login($user);

            // Clear session data
            session()->forget(['user_data', 'password', 'verification_code']);

            // Send success response with redirect URL
            return response()->json([
                'success' => true,
                'redirect' => route('user.dashboard')
            ]);
        }

        // Send error response for invalid verification code
        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code'
        ]);
    }



    public static function logout(Request $request){

        DB::table('user_sessions')
        ->where('session_id', session()->getId())
        ->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }

    public function signin(Request $request) {
        if (Auth::check()) {
            return response()->json([
                'success' => true,
                'redirect' => route('home')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Attempt to log in the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            $profile = Auth::user();

            if ($profile) {
                if ($profile->status == 1) {
                    Auth::logout();
                    return response()->json([
                        'success' => false,
                        'message' => 'Your profile has been blocked.'
                    ], 401);
                }
            }

            // Clean up expired sessions before counting active sessions
            $this->removeExpiredSessions($profile->id);

            // Check active session count
            $activeSessions = DB::table('user_sessions')->where('user_id', $profile->id)->count();

            if ($activeSessions >= 2) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot log in from more than 2 devices.'
                ], 401);
            }

            // Store the new session
            DB::table('user_sessions')->insert([
                'user_id' => $profile->id,
                'session_id' => session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
                'expires_at' => now()->addHours(2),
            ]);

            return response()->json([
                'success' => true,
                'redirect' => route('user.dashboard')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);
        }
    }


    public static function register(){

        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.register', [
        ]);
    }

    public static function login(){

        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('frontend.auth.auth', [
        ]);
    }


    public static function forgetPass() {
        return view('frontend.auth.forgetPassword',[

        ]);
    }

    public function verifyEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Email not found.']);
    }

    // Generate 6-digit verification code
    $code = rand(100000, 999999);

    // Store the code in session (or use a database to store temporary codes)
    Session::put('password_reset_code', $code);
    Session::put('password_reset_email', $user->email);

    try {
        // Send the code via email
        Mail::to($user->email)->send(new PasswordResetCodeMail($code));
    } catch (\Exception $e) {
        Log::error('Failed to send password reset email: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
    }

    return response()->json(['success' => true, 'message' => 'Verification code sent to your email.']);
}




    // Step 3: Reset password
//     public function resetPassword(Request $request)
// {
//     $request->validate([
//         'prevemail' => 'required|email',
//         'prevcode' => 'required|integer',
//         'password' => 'required|string|min:8|confirmed',
//     ]);

//     $storedCode = $request->session()->get('password_reset_code');
//     $storedEmail = $request->session()->get('password_reset_email');

//     if ($storedCode != $request->prevcode || $storedEmail != $request->prevemail) {
//         return response()->json(['success' => false, 'message' => 'Invalid code or email.']);
//     }

//     $user = User::where('email', $storedEmail)->first();
//     if (!$user) {
//         return response()->json(['success' => false, 'message' => 'User not found.']);
//     }

//     $user->password = bcrypt($request->password);
//     $user->save();

//     $request->session()->forget(['password_reset_code', 'password_reset_email']);

//     return response()->json([
//         'success' => true,
//         'message' => 'Password successfully updated.',
//         'redirect' => route('login')
//     ]);
// }


public function sendResetCode(Request $request)
    {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // Return validation errors if failed
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if user exists with that email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No user found using that email'], 422);
        }

        // Generate a random 6-digit code
        $resetCode = rand(100000, 999999);

        // Save the reset code in session
        session(['reset_code' => $resetCode, 'reset_email' => $request->email]);

        // Send email with the reset code using the Mailable class
        Mail::to($user->email)->send(new ResetPasswordCodeMail($user, $resetCode));

        return response()->json(['message' => 'Verification Code has been sent to your Email', 'email' => $user->email], 200);
    }

    // Step 2: Verify Code
    public function resetVerifyCode(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->code != session('reset_code')) {
            return response()->json(['message' => 'Invalid Code'], 422);
        }

        return response()->json(['message' => 'Verification Code Verified', 'code' => $request->code], 200);
    }

    // Step 3: Reset Password
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->email !== session('reset_email')) {
            return response()->json(['message' => 'Invalid Email'], 422);
        }

        if ($request->code != session('reset_code')) {
            return response()->json(['message' => 'Invalid Code'], 422);
        }

        $user = User::where('email', $request->email)->first();

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear the session data
        session()->forget(['reset_code', 'reset_email']);

        return response()->json(['message' => 'Password has been reset successfully'], 200);
    }

    private function removeExpiredSessions($userId) {
        DB::table('user_sessions')
            ->where('user_id', $userId)
            ->where('expires_at', '<', now())  // Remove sessions that have expired
            ->delete();
    }

}
