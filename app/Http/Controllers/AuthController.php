<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as Pengguna; // Pastikan model User sudah dibuat dan sesuai dengan nama tabel 'pengguna'
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login pelanggan
    public function login()
    {
        return view('login'); 
        // Catatan: Jika file-nya sudah kamu pindahkan ke folder 'auth', 
        // ubah kodenya menjadi return view('auth.login');
    }

    // Menampilkan halaman login khusus admin
    public function loginAdmin()
    {
        return view('login-admin');
    }

    // Menampilkan halaman pendaftaran member/pelanggan baru
    public function register()
    {
        return view('register');
    }

    public function prosesLogin(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek kecocokan email dan password di database
        if (Auth::attempt($credentials)) {
            // Jika cocok, buat sesi login (keamanan wajib Laravel)
            $request->session()->regenerate();

            // Cek role: Kalau admin lempar ke dashboard admin, kalau pelanggan ke halaman reservasi
            if(Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/reservasi'); 
        }

        // 3. Jika gagal/tidak cocok, kembalikan ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }


    public function prosesRegister(Request $request)
    {
        // 1. Validasi data dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'nomor_telepon' => 'nullable|string|max:20'
        ]);

        // 2. Simpan ke database
        Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password diamankan
            'nomor_telepon' => $request->nomor_telepon,
            'role' => 'pelanggan', // Otomatis jadi pelanggan
            'poin' => 0
        ]);

        // 3. Arahkan ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

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
        // Mengembalikan tampilan halaman profile.blade.php
        return view('profile');
    }

/**
     * Memperbarui Informasi Teks Profil (Nama Lengkap & Nomor Telepon)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
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
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama dari storage jika ada untuk menghemat ruang
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }

            // Simpan file baru ke folder storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');

            // Simpan path file baru tersebut ke database
            Pengguna::where('id', $user->id)->update([
                'avatar' => $path
            ]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto profil.');
    }
}