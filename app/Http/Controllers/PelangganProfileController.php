<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Pelanggan; // Make sure your Pelanggan model is correctly namespaced

class PelangganProfileController extends Controller
{
    /**
     * Show the customer's profile page.
     */
    public function show()
    {
        // The auth middleware already ensures the user is logged in.
        // The blade file directly accesses Auth::guard('pelanggan')->user()
        // So, we just need to return the view.
        return view('profil-pelanggan'); // Assuming your blade file is named 'profile.blade.php'
    }

    /**
     * Update the customer's profile information.
     */
    public function updateProfile(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', // Adjusted to match your model's enum
        ]);

        $pelanggan->nama_pelanggan = $request->nama;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->jenis_kelamin = $request->jenis_kelamin;
        $pelanggan->save();

        return redirect()->route('pelanggan.profile.show')->with('successProfile', 'Profile updated successfully!');
    }

    /**
     * Update the customer's account information (email, phone).
     */
    public function updateAccountInfo(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'telp' => 'required|string|max:15',
            'email' => 'required|string|email|max:100|unique:pelanggan,email,' . $pelanggan->id_pelanggan . ',id_pelanggan',
        ]);

        $pelanggan->telp = $request->telp;
        $pelanggan->email = $request->email;
        $pelanggan->save();

        return redirect()->route('pelanggan.profile.show')->with('successAccountInfo', 'Account info updated successfully!');
    }

    /**
     * Change the customer's password.
     */
    public function changePassword(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'old_password' => ['required', function ($attribute, $value, $fail) use ($pelanggan) {
                if (!Hash::check($value, $pelanggan->password)) {
                    $fail('The ' . $attribute . ' is incorrect.');
                }
            }],
            'new_password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        $pelanggan->password = Hash::make($request->new_password);
        $pelanggan->save();

        return redirect()->route('pelanggan.profile.show')->with('successPassword', 'Password changed successfully!');
    }
}