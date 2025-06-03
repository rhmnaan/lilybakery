<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
{
    $customers = \App\Models\Pelanggan::all();

    $activeCount   = $customers->where('status', 'active')->count();
    $inactiveCount = $customers->where('status', 'inactive')->count();
    $totalCount    = $customers->count();

    return view('admin.customers', compact(
        'customers', 'activeCount', 'inactiveCount', 'totalCount'
    ));
}

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
        ]);

        return redirect()->route('admin.customers')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $customer = Pelanggan::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
