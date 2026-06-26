<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\User as Pengguna; // Menggunakan kapital 'User' sesuai standar penamaan Laravel
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pengaturan;

class DashboardAdminController extends Controller
{
    // ==========================================
    // 1. HALAMAN RINGKASAN UTAMA (DASHBOARD)
    // ==========================================
    public function index()
    {
        $today = Carbon::today();

        // Hitung Pendapatan Hari Ini (dari kolom ongkir/DP sementara)
        $pendapatanHariIni = Reservasi::whereDate('created_at', $today)
                                ->where('status', 'selesai')
                                ->sum('ongkir');

        // Hitung Pesanan Baru (Delivery & Pickup hari ini)
        $pesananBaru = Reservasi::whereDate('created_at', $today)
                            ->whereIn('jenis_pesanan', ['delivery', 'pickup'])
                            ->count();

        // Hitung Reservasi Menunggu (Dine-in yang statusnya masih menunggu)
        $reservasiMenunggu = Reservasi::where('jenis_pesanan', 'dine_in')
                                ->where('status', 'menunggu')
                                ->count();

        // Total Pelanggan terdaftar
        $totalPelanggan = Pengguna::where('role', 'pelanggan')->count();

        // Daftar Pesanan Terbaru (Ambil 5 transaksi terakhir)
        $recentOrders = Reservasi::with('pengguna')
                            ->whereIn('jenis_pesanan', ['delivery', 'pickup'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        // Jadwal Reservasi Terdekat (Ambil 3 booking mendatang)
        $upcomingReservations = Reservasi::with(['pengguna', 'meja'])
                                    ->where('jenis_pesanan', 'dine_in')
                                    ->where('tanggal_reservasi', '>=', $today)
                                    ->where('status', 'menunggu')
                                    ->orderBy('tanggal_reservasi', 'asc')
                                    ->orderBy('jam_mulai', 'asc')
                                    ->limit(3)
                                    ->get();

        return view('admin.dashboard', compact(
            'pendapatanHariIni', 
            'pesananBaru', 
            'reservasiMenunggu', 
            'totalPelanggan', 
            'recentOrders', 
            'upcomingReservations'
        ));
    }

    // ==========================================
    // 2. FITUR UNDUH LAPORAN (EXPORT CSV)
    // ==========================================
    public function exportLaporan()
    {
        $fileName = 'laporan_roastory_' . date('Y-m-d') . '.csv';
        $tasks = Reservasi::with('pengguna')->orderBy('created_at', 'desc')->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID Pesanan', 'Pelanggan', 'Jenis Pesanan', 'Total Transaksi', 'Status', 'Tanggal');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                fputcsv($file, array(
                    '#ORD-' . str_pad($task->id, 4, '0', STR_PAD_LEFT),
                    $task->pengguna->nama ?? 'Tamu Walk-in',
                    ucfirst($task->jenis_pesanan),
                    'Rp ' . number_format($task->ongkir ?? 0, 0, ',', '.'),
                    ucfirst($task->status),
                    $task->created_at ? $task->created_at->format('d M Y, H:i') : '-'
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==========================================
    // 3. MANAJEMEN KATALOG MENU
    // ==========================================
    public function menus()
    {
        $dataMenu = Menu::all(); 
        $dataKategori = DB::table('kategori_menu')->get(); 
        return view('admin.menus', compact('dataMenu', 'dataKategori'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_menu_id' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'tersedia' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
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

        $namaGambar = $menu->gambar;
        
        if ($request->hasFile('gambar')) {
            if ($menu->gambar && file_exists(public_path('uploads/menus/' . $menu->gambar))) {
                unlink(public_path('uploads/menus/' . $menu->gambar));
            }
            
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

    public function hapusMenu($id)
    {
        $menu = Menu::findOrFail($id);
        
        if ($menu->gambar && file_exists(public_path('uploads/menus/' . $menu->gambar))) {
            unlink(public_path('uploads/menus/' . $menu->gambar));
        }

        $menu->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus dari katalog!');
    }

    // ==========================================
    // 4. MANAJEMEN RESERVASI (DINE-IN)
    // ==========================================
    public function indexReservasi(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        // Mengurutkan berdasarkan jam_mulai paling awal untuk tanggal terpilih
        $dataReservasi = Reservasi::with(['pengguna', 'meja'])
            ->where('jenis_pesanan', 'dine_in')
            ->whereDate('tanggal_reservasi', $tanggal)
            ->orderBy('jam_mulai', 'asc')
            ->get();
        
        $dataMeja = Meja::all(); 

        $totalHariIni = $dataReservasi->count();
        $menunggu = $dataReservasi->whereIn('status', ['menunggu', 'diproses', 'dikonfirmasi'])->count();
        $hadir = $dataReservasi->whereIn('status', ['selesai', 'hadir'])->count();

        return view('admin.reservations', compact('dataReservasi', 'tanggal', 'totalHariIni', 'menunggu', 'hadir', 'dataMeja'));
    }

    public function storeReservasi(Request $request)
    {
        // total_harga dibuat nullable agar tidak error jika DP dikosongkan (Walk-in)
        $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'nomor_telepon'     => 'required|string|max:20',
            'tanggal_reservasi' => 'required|date',
            'jam_mulai'         => 'required',
            'meja_id'           => 'required',
            'total_tamu'        => 'required|integer|min:1',
            'total_harga'       => 'nullable|numeric', 
        ]);

        $pelanggan = Pengguna::firstOrCreate(
            ['nomor_telepon' => $request->nomor_telepon],
            [
                'nama' => $request->nama_pelanggan,
                'role' => 'pelanggan',
                'email' => $request->nomor_telepon . '@tamu.com', 
                'password' => bcrypt('tamu1234')
            ]
        );

        Reservasi::create([
            'pengguna_id'       => $pelanggan->id,
            'jenis_pesanan'     => 'dine_in',
            'meja_id'           => $request->meja_id,
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
            'total_tamu'        => $request->total_tamu,
            'total_harga'       => $request->total_harga ?? 0, // Jika kosong otomatis bernilai 0
            'status'            => 'dikonfirmasi' // Langsung konfirmasi karena diinput manual oleh admin
        ]);

        return redirect()->back()->with('success', 'Reservasi manual berhasil ditambahkan!');
    }

    public function updateStatusReservasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,dikonfirmasi,selesai,dibatalkan'
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui!');
    }

    // ==========================================
    // 5. MANAJEMEN PESANAN (DELIVERY / PICKUP)
    // ==========================================
    public function indexPesanan()
    {
        $dataPesanan = Reservasi::with(['pengguna'])
            ->whereIn('jenis_pesanan', ['delivery', 'pickup'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders', compact('dataPesanan'));
    }

    public function updateStatusPesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,dibatalkan'
        ]);

        $pesanan = Reservasi::findOrFail($id);
        $pesanan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
    
    // ==========================================
    // 6. MANAJEMEN PENGGUNA (PELANGGAN)
    // ==========================================
    public function users()
    {
        $dataPengguna = Pengguna::where('role', 'pelanggan')->get();
        return view('admin.users', compact('dataPengguna'));
    }

    public function hapusUser($id)
    {
        $user = Pengguna::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }

    // ==========================================
    // FITUR PENCARIAN GLOBAL
    // ==========================================
    public function globalSearch(Request $request)
    {
        // 1. Ambil kata kunci dari form
        $keyword = $request->input('q');

        // Jika kotak pencarian kosong, kembalikan ke halaman sebelumnya
        if (empty($keyword)) {
            return redirect()->back();
        }

        // 2. Cari di Tabel Menu (Berdasarkan Nama atau Deskripsi)
        $hasilMenu = Menu::where('nama', 'LIKE', "%{$keyword}%")
                        ->orWhere('deskripsi', 'LIKE', "%{$keyword}%")
                        ->get();

        // 3. Cari di Tabel Pengguna (Berdasarkan Nama atau Nomor Telepon)
        $hasilPengguna = Pengguna::where('role', 'pelanggan')
                        ->where(function($query) use ($keyword) {
                            $query->where('nama', 'LIKE', "%{$keyword}%")
                                  ->orWhere('nomor_telepon', 'LIKE', "%{$keyword}%");
                        })->get();

        // 4. Cari di Tabel Reservasi / Pesanan 
        // (Berdasarkan ID Pesanan ATAU Nama Pelanggan yang memesan)
        $hasilReservasi = Reservasi::with('pengguna')
                        ->where('id', 'LIKE', "%{$keyword}%")
                        ->orWhereHas('pengguna', function($query) use ($keyword) {
                            $query->where('nama', 'LIKE', "%{$keyword}%")
                                  ->orWhere('nomor_telepon', 'LIKE', "%{$keyword}%");
                        })->get();

        // 5. Kirim semua hasil ke halaman view khusus pencarian
        return view('admin.search_results', compact('keyword', 'hasilMenu', 'hasilPengguna', 'hasilReservasi'));
    }

    // ==========================================
    // 6. MANAJEMEN PENGATURAN
    // ==========================================
    public function settings()
    {
        $googleMapsUrl = Pengaturan::where('kunci', 'google_maps_embed_url')->value('nilai');
        return view('admin.settings', compact('googleMapsUrl'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'google_maps_embed_url' => 'required|url',
        ]);

        Pengaturan::updateOrCreate(
            ['kunci' => 'google_maps_embed_url'],
            ['nilai' => $request->google_maps_embed_url]
        );

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}