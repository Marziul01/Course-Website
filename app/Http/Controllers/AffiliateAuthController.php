<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AffiliateVerificationCode;
use Illuminate\Support\Facades\Validator;

class AffiliateAuthController extends Controller
{
    public function affiliateRegister(Request $request)
{
    // Validation
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'phone'  => 'required|unique:users,number',
        'email'  => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'affiliate_link' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Generate 6-digit verification code
    $verificationCode = rand(100000, 999999);

    // Save code to session for verification later
    session(['verification_code' => $verificationCode, 'affiliate_data' => $request->all()]);

    // Send email with the verification code
    Mail::to($request->email)->send(new AffiliateVerificationCode($verificationCode));

    return response()->json([
        'success' => true,
        'email' => $request->email,
    ]);
}

public function verifyCode(Request $request)
{
    $inputCode = $request->verification_code;
    $storedCode = session('verification_code');

    if ($inputCode == $storedCode) {
        // Retrieve affiliate data from session
        $affiliateData = session('affiliate_data');

        // Create the user as an affiliate
        $user = new User;
        $user->role_name = 'affiliate';
        $user->affiliate_link = $affiliateData['affiliate_link'];
        $user->name = $affiliateData['name'];
        $user->email = $affiliateData['email'];
        $user->number = $affiliateData['phone'];
        $user->password = Hash::make($affiliateData['password']);
        $user->save();

        // Log in the user
        Auth::login($user);

        // Clear session data
        session()->forget(['verification_code', 'affiliate_data']);

        return response()->json([
            'success' => true,
            'redirect' => route('user.dashboard')
        ]);
    } else {
        return response()->json([
            'success' => false,
        ]);
    }
}
}
