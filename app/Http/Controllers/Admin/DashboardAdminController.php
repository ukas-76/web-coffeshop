<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\user as Pengguna; // Pastikan model User sudah dibuat dan sesuai dengan nama tabel 'pengguna'
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    // 1. Halaman Manajemen Reservasi (Khusus Dine-in)
    public function indexReservasi(Request $request)
    {
        // 1. Tangkap tanggal dari filter kalender, jika kosong gunakan hari ini
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        // 2. Ambil data dari database berdasarkan tanggal yang difilter
        $dataReservasi = Reservasi::with(['pengguna', 'meja'])
            ->where('jenis_pesanan', 'dine_in')
            ->whereDate('tanggal_reservasi', $tanggal)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        
        $dataMeja = Meja::all(); 

        $totalHariIni = $dataReservasi->count();
        $menunggu = $dataReservasi->whereIn('status', ['menunggu', 'diproses', 'dikonfirmasi'])->count();
        $hadir = $dataReservasi->whereIn('status', ['selesai', 'hadir'])->count();

    // 2. Jangan lupa tambahkan 'dataMeja' ke dalam compact
    return view('admin.reservations', compact('dataReservasi', 'tanggal', 'totalHariIni', 'menunggu', 'hadir', 'dataMeja'));

        // 3. Hitung statistik untuk Kartu Ringkasan di atas tabel
        $totalHariIni = $dataReservasi->count();
        $menunggu = $dataReservasi->whereIn('status', ['menunggu', 'diproses', 'dikonfirmasi'])->count();
        $hadir = $dataReservasi->whereIn('status', ['selesai', 'hadir'])->count();

        // 4. Kirim semua data tersebut ke file view
        return view('admin.reservations', compact('dataReservasi', 'tanggal', 'totalHariIni', 'menunggu', 'hadir'));
    }

    public function storeReservasi(Request $request)
    {
        // 1. Validasi input dari form modal
        $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'nomor_telepon'     => 'required|string|max:20',
            'tanggal_reservasi' => 'required|date',
            'jam_mulai'         => 'required',
            'meja_id'           => 'required',
            'total_tamu'        => 'required|integer|min:1',
        ]);

        // 2. Cari atau Buat Akun Pelanggan (berdasarkan Nomor Telepon)
        $pelanggan = Pengguna::firstOrCreate(
            ['nomor_telepon' => $request->nomor_telepon],
            [
                'nama' => $request->nama_pelanggan,
                'role' => 'pelanggan',
                // Data dummy wajib jika tabel pengguna mengharuskan email/password
                'email' => $request->nomor_telepon . '@tamu.com', 
                'password' => bcrypt('tamu1234')
            ]
        );

        // 3. Simpan data ke tabel Reservasi
        Reservasi::create([
            'pengguna_id'       => $pelanggan->id,
            'jenis_pesanan'     => 'dine_in',
            'meja_id'           => $request->meja_id,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
            'total_tamu'        => $request->total_tamu,
            'ongkir'            => $request->dp_dibayar ?? 0, // DP masuk ke ongkir sementara
            'status'            => 'dikonfirmasi' // Otomatis dikonfirmasi karena dibuat oleh Admin
        ]);

        // 4. Kembalikan ke halaman semula
        return redirect()->back()->with('success', 'Reservasi manual berhasil ditambahkan!');
    }

    public function updateStatusReservasi(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:menunggu,diproses,dikonfirmasi,selesai,dibatalkan'
        ]);

        // Cari data reservasinya dan perbarui
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui!');
    }

// 2. Halaman Daftar Pesanan (Khusus Delivery dan Pick-up)
    public function indexPesanan()
    {
        $dataPesanan = Reservasi::with(['pengguna'])
            ->whereIn('jenis_pesanan', ['delivery', 'pickup'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders', compact('dataPesanan'));
    }

    // Fungsi untuk memperbarui status pesanan dari Modal Edit
    public function updateStatusPesanan(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan'
        ]);

        // Cari pesanannya, lalu ubah statusnya
        $pesanan = Reservasi::findOrFail($id);
        $pesanan->update([
            'status' => $request->status
        ]);

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
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