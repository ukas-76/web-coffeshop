<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\user as Pengguna; // Pastikan model User sudah dibuat dan sesuai dengan nama tabel 'pengguna'

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }

    public function menus()
    {
        return view('admin.menus');
    }

    public function orders()
    {
        return view('admin.orders');
    }

    public function reservations()
    {
        return view('admin.reservations');
    }
    
    public function users()
    {
        // Mengambil semua data pengguna dengan role 'pelanggan'
        $dataPengguna = Pengguna::where('role', 'pelanggan')->get();
        
        // Mengirim data ke view admin/users.blade.php
        return view('admin.users', compact('dataPengguna'));
    }

    public function hapusUser($id)
    {
        $user = Pengguna::findOrFail($id); // Cari user berdasarkan ID
        $user->delete(); // Hapus dari database

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}