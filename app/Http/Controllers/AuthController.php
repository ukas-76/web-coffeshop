<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login pelanggan
    public function login()
    {
        return view('login'); 
    }

    // Menampilkan halaman login khusus admin
    public function loginAdmin()
    {
        return view('login-admin');
    }

    // Memproses form login khusus admin
    public function prosesLoginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            // Pastikan yang login memiliki role admin atau superadmin
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin') {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }

            // Jika pelanggan biasa nyasar mencoba login lewat gerbang admin
            Auth::logout();
            return back()->with('error', 'Akses ditolak! Anda tidak memiliki otorisasi Admin.');
        }

        return back()->with('error', 'Kredensial tidak valid. Silakan periksa kembali ID dan Kata Sandi Anda.');
    }

    // Menampilkan halaman pendaftaran member/pelanggan baru
    public function register()
    {
        return view('register');
    }

    // Memproses form login pelanggan
    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek role: Kalau admin lempar ke dashboard admin, kalau pelanggan ke halaman reservasi
            if(Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/reservasi'); 
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses pendaftaran member baru
    public function prosesRegister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'nomor_telepon' => 'nullable|string|max:20'
        ]);

        Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            'role' => 'pelanggan',
            'poin' => 0
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Memproses logout pengguna
    public function prosesLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Kamu telah berhasil keluar.');
    }
}