<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Menampilkan halaman daftar pelanggan.
     */
    public function index()
    {
        // Mengambil semua data pelanggan
        $customers = \App\Models\Pelanggan::orderBy('nama_pelanggan', 'asc')->get();
        
        // Menghitung total pelanggan
        $totalCount = $customers->count();

        // Mengirim data ke view
        return view('admin.customers', compact('customers', 'totalCount'));
    }

    /**
     * Menyimpan pelanggan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:pelanggan,email',
            'phone'    => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'gender'   => 'required|in:Laki-laki,Perempuan',
            'address'  => 'required|string|max:255',
        ]);

        Pelanggan::create([
            'nama_pelanggan' => $request->name,
            'email'          => $request->email,
            'telp'           => $request->phone,
            'password'       => Hash::make($request->password),
            'jenis_kelamin'  => $request->gender,
            'alamat'         => $request->address,
            // Kolom status tidak lagi diisi secara eksplisit
        ]);

        return redirect()->route('admin.customers')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Menghapus pelanggan.
     */
    public function destroy($id)
    {
        $customer = Pelanggan::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers')->with('success', 'Pelanggan berhasil dihapus.');
    }
}