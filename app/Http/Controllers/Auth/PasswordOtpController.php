<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordOtp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PasswordOtpController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.otp-request');
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);

        $user = User::where('email', $data['email'])->first();
        if (! $user) {
            return back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        }

        $otp = (string) random_int(100000, 999999);

        PasswordOtp::create([
            'email' => $data['email'],
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($data['email'])->send(new OtpMail($otp, $data['email']));

        session(['password_reset_email' => $data['email']]);

        return redirect()->route('password.otp.verify')->with('status', 'OTP sent to your email');
    }

    public function showVerifyForm()
    {
        return view('auth.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $record = PasswordOtp::where('email', $data['email'])
            ->where('otp', $data['otp'])
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (! $record) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau kadaluarsa.']);
        }

        session(['password_otp_verified' => true, 'password_reset_email' => $data['email']]);

        return redirect()->route('password.otp.reset');
    }

    public function showResetForm()
    {
        if (! session('password_otp_verified') || ! session('password_reset_email')) {
            return redirect()->route('password.otp.request')->withErrors(['email' => 'Please request an OTP first.']);
        }

        return view('auth.reset-password-otp');
    }

    public function resetPassword(Request $request)
    {
        if (! session('password_otp_verified') || ! session('password_reset_email')) {
            return redirect()->route('password.otp.request')->withErrors(['email' => 'Please request an OTP first.']);
        }

        $data = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('password_reset_email');
        $user = User::where('email', $email)->first();
        if (! $user) {
            return redirect()->route('password.otp.request')->withErrors(['email' => 'User not found.']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        // Cleanup
        PasswordOtp::where('email', $email)->delete();
        session()->forget(['password_otp_verified', 'password_reset_email']);

        return redirect()->route('login')->with('status', 'Password updated successfully. You may login now.');
    }
}
