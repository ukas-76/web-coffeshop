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
    // Mengeluarkan pengguna dari sesi autentikasi Laravel
    Auth::logout();

    // Menghapus seluruh data sesi agar aman
    $request->session()->invalidate();

    // Membuat ulang token CSRF baru untuk mencegah serangan CSRF
    $request->session()->regenerateToken();

    // Mengalihkan pengguna kembali ke halaman utama
    return redirect('/')->with('success', 'Kamu telah berhasil keluar.');
}

public function profile()
    {
        // 1. Ambil data pengguna yang sedang login
        $user = auth()->guard('web')->user();

        // 2. Ambil riwayat Pesanan Online (Delivery & Pickup)
        $riwayatPesanan = Reservasi::where('pengguna_id', $user->id)
            ->whereIn('jenis_pesanan', ['delivery', 'pickup'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Ambil riwayat Reservasi Meja (Dine-in)
        $riwayatReservasi = Reservasi::where('pengguna_id', $user->id)
            ->where('jenis_pesanan', 'dine_in')
            ->orderBy('created_at', 'desc')
            ->get();

        // 4. Kirim variabel ke view profile.blade.php
        return view('profile', compact('user', 'riwayatPesanan', 'riwayatReservasi'));
    }

    /**
     * Memperbarui Informasi Teks Profil (Nama Lengkap & Nomor Telepon)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Mengupdate data user ke tabel pengguna menggunakan model Pengguna
        Pengguna::where('id', $user->id)->update([
            'nama' => $request->name,
            'nomor_telepon' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Informasi pribadi berhasil diperbarui!');
    }

    /**
     * Memperbarui Foto Profil / Avatar User (Mengatasi Error Saat Upload)
     */
    public function updateAvatar(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Kamu telah berhasil keluar.');
    }
}