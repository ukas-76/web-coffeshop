<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\user as Pengguna; // Pastikan model User sudah dibuat dan sesuai dengan nama tabel 'pengguna'
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }

    public function menus()
    {
        // 1. Ambil semua data menu
        $dataMenu = Menu::all(); 
        
        // 2. Ambil semua data dari tabel kategori_menu
        $dataKategori = DB::table('kategori_menu')->get(); 
        
        // 3. Kirim kedua variabel ke halaman view
        return view('admin.menus', compact('dataMenu', 'dataKategori'));
    }
    
    public function hapusMenu($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Hapus file gambar dari penyimpanan jika ada
        if ($menu->gambar && file_exists(public_path('uploads/menus/' . $menu->gambar))) {
            unlink(public_path('uploads/menus/' . $menu->gambar));
        }

        $menu->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus dari katalog!');
    }

    // Fungsi CREATE: Menyimpan menu baru
    public function storeMenu(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_menu_id' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tersedia' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib gambar, max 2MB
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            // Simpan gambar ke folder public/uploads/menus
            $file->move(public_path('uploads/menus'), $namaGambar);
        }

        Menu::create([
            'nama' => $request->nama,
            'kategori_menu_id' => $request->kategori_menu_id, 
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'tersedia' => $request->tersedia, 
            'gambar' => $namaGambar,
        ]);

        return redirect()->back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    // Fungsi UPDATE: Menyimpan editan menu
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_menu_id' => 'required', 
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tersedia' => 'required',         
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $namaGambar = $menu->gambar; // Gunakan gambar lama secara default
        
        // Jika admin mengunggah gambar baru
        if ($request->hasFile('gambar')) {
            // 1. Hapus gambar lama
            if ($menu->gambar && file_exists(public_path('uploads/menus/' . $menu->gambar))) {
                unlink(public_path('uploads/menus/' . $menu->gambar));
            }
            
            // 2. Simpan gambar baru
            $file = $request->file('gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/menus'), $namaGambar);
        }

        $menu->update([
            'nama' => $request->nama,
            'kategori_menu_id' => $request->kategori_menu_id,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'tersedia' => $request->tersedia,
            'gambar' => $namaGambar,
        ]);

        return redirect()->back()->with('success', 'Data menu berhasil diperbarui!');
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