<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Mendaftarkan pelanggan baru, menyimpan data ke session, membuat OTP,
     * dan mengirimkannya melalui email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi data input dari form registrasi
        $validator = Validator::make($request->all(), [
            'name_pelanggan' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan,email',
            'password' => 'required|string|min:8',
            'telp' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate OTP dan waktu kadaluarsanya (5 menit)
        $otp = rand(100000, 999999);
        $otpExpiresAt = Carbon::now()->addMinutes(5);

        // Buat record pelanggan. Data lengkap akan diisi setelah verifikasi OTP.
        $pelanggan = Pelanggan::create([
            'name_pelanggan' => $request->name_pelanggan,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'otp' => $otp,
            'otp_expires_at' => $otpExpiresAt,
            'email_verified' => false,
        ]);

        // LOGIKA ASLI: Simpan data registrasi (termasuk password) ke session
        session(['otp_register_data' => $request->except('_token')]);

        // Kirim email yang berisi OTP ke pelanggan
        try {
            Mail::to($pelanggan->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email OTP: ' . $e->getMessage());
            return redirect()->route('register.form')->with([
                'error' => 'Gagal mengirim OTP ke email',
            ]);
        }

        // Arahkan ke halaman verifikasi OTP
        return redirect()->route('verify.otp.form')->with([
            'message' => 'Registrasi berhasil. Silakan verifikasi email Anda.',
            'email' => $pelanggan->email
        ]);
    }

    /**
     * Memverifikasi OTP, dan jika berhasil, menyimpan data lengkap dari session ke database.
     * Logika ini dikembalikan 100% sesuai kode asli.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'otp' => 'required|string|min:6|max:6',
        ]);

        if ($validator->fails()) {
            return $request->expectsJson()
                ? response()->json(['errors' => $validator->errors()], 422)
                : redirect()->back()->withErrors($validator)->withInput();
        }

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Pelanggan tidak ditemukan.'], 404)
                : redirect()->back()->with('error', 'Pelanggan tidak ditemukan.');
        }

        // Cek jika OTP valid dan belum kadaluarsa
        if ($pelanggan->otp === $request->otp && Carbon::now()->lessThanOrEqualTo($pelanggan->otp_expires_at)) {
            // Ambil data dari session
            $data = session('otp_register_data');

            if (!$data) {
                return $request->expectsJson()
                    ? response()->json(['message' => 'Data registrasi tidak ditemukan di session.'], 400)
                    : redirect()->route('register.form')->with('error', 'Sesi Anda telah berakhir, silakan daftar ulang.');
            }
            
            // LOGIKA ASLI: Update data pelanggan dari session.
            // PERHATIKAN: Pastikan key di session (cth: $data['name']) cocok dengan nama field di form Anda.
            // Validator menggunakan 'name_pelanggan', tapi di kode asli Anda menggunakan 'name', 'phone', 'address', 'gender'.
            // Ini adalah sumber error yang paling umum.
            $pelanggan->nama_pelanggan = $data['name'];
            $pelanggan->password = bcrypt($data['password']);
            $pelanggan->telp = $data['phone'];
            $pelanggan->alamat = $data['address'];
            $pelanggan->jenis_kelamin = $data['gender'] === 'Laki-Laki' ? 'Laki-laki' : 'Perempuan';
            
            // Set email terverifikasi dan hapus OTP
            $pelanggan->email_verified = true;
            $pelanggan->otp = null;
            $pelanggan->otp_expires_at = null;
            $pelanggan->save();
            
            // Hapus data dari session
            session()->forget('otp_register_data');

            return $request->expectsJson()
                ? response()->json(['message' => 'Email berhasil diverifikasi dan data disimpan.'])
                : redirect()->route('pelanggan.login.form')->with('success', 'Email berhasil diverifikasi. Silakan login.');
        }
        
        // Jika OTP salah, kembalikan ke form OTP
        session(['email' => $request->email]);
        
        return $request->expectsJson()
            ? response()->json(['message' => 'OTP tidak valid atau sudah kadaluarsa.'], 400)
            : redirect()->route('verify.otp.form')->with('error', 'OTP tidak valid atau sudah kadaluarsa.');
    }

    /**
     * Mengirim ulang OTP untuk verifikasi email pendaftaran.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        if ($pelanggan->email_verified) {
            return redirect()->route('pelanggan.login.form')->with('message', 'Email sudah diverifikasi. Silakan login.');
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);
        $pelanggan->otp = $otp;
        $pelanggan->otp_expires_at = Carbon::now()->addMinutes(10);
        $pelanggan->save();
        
        session(['email' => $pelanggan->email]);
        Mail::to($pelanggan->email)->send(new OtpMail($otp));

        return redirect()->route('verify.otp.form')->with('message', 'OTP baru telah dikirim.');
    }

}    