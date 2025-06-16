<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\OtpMail;

class ForgotPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        $otp = rand(100000, 999999);
        $pelanggan->otp = $otp;
        $pelanggan->otp_expires_at = Carbon::now()->addMinutes(10);
        $pelanggan->save();

        session(['reset_email' => $pelanggan->email]);

        Mail::to($pelanggan->email)->send(new OtpMail($otp));

        return redirect()->route('forgot.password.verify.form')->with('message', 'OTP telah dikirim ke email Anda.');
    }

    public function showVerifyOtpForm()
    {
        return view('auth.verify-forgot-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|min:6|max:6',
            'email' => 'required|email',
        ]);

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan || $pelanggan->otp !== $request->otp || Carbon::now()->gt($pelanggan->otp_expires_at)) {
            return back()->with('error', 'OTP salah atau sudah kedaluwarsa.');
        }

        session(['reset_email_verified' => true]);

        return redirect()->route('forgot.password.reset.form');
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        $otp = rand(100000, 999999);
        $pelanggan->otp = $otp;
        $pelanggan->otp_expires_at = Carbon::now()->addMinutes(10);
        $pelanggan->save();

        Mail::to($pelanggan->email)->send(new OtpMail($otp));

        return back()->with('message', 'OTP baru telah dikirim.');
    }

    public function showResetForm()
    {
        if (!session('reset_email_verified')) {
            return redirect()->route('forgot.password.form')->with('error', 'Verifikasi OTP terlebih dahulu.');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email');

        $pelanggan = Pelanggan::where('email', $email)->first();
        if (!$pelanggan) {
            return redirect()->route('forgot.password.form')->with('error', 'Data tidak ditemukan.');
        }

        $pelanggan->password = Hash::make($request->password);
        $pelanggan->otp = null;
        $pelanggan->otp_expires_at = null;
        $pelanggan->save();

        session()->forget(['reset_email', 'reset_email_verified']);

        return redirect()->route('pelanggan.login.form')->with('success', 'Password berhasil direset. Silakan login.');
    }
}
