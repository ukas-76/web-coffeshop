<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\DetailReservasi; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Menampilkan halaman Menu Pesanan Online (order.blade.php)
     * Menggunakan pengelompokan nama kategori yang bersih melalui relasi
     */
    public function order()
    {
        // Mengambil menu yang tersedia beserta nama kategorinya langsung
        $menus = Menu::where('tersedia', '1')
            ->with('kategori') // Eager load relasi kategori
            ->get()
            ->groupBy(function($item) {
                // Mengelompokkan berdasarkan nama kategori asli di database
                return $item->kategori->nama ?? 'Lainnya'; 
            });

        return view('order', compact('menus'));
    }

    /**
     * Menampilkan halaman Pembayaran (payment.blade.php)
     */
    public function payment(Request $request)
    {
        // Menangkap nominal total belanja dan ID reservasi dari URL
        $amount = $request->query('amount', 0);
        $reservasi_id = $request->query('reservasi_id');

        return view('payment', compact('amount', 'reservasi_id'));
    }

    /**
     * Memproses checkout dari Keranjang Belanja Online (Delivery / Pickup)
     * dan memasukkannya langsung ke dalam tabel 'reservasi' dan 'detail_reservasi'
     */
    public function prosesCheckout(Request $request)
    {
        // Validasi input data dari AJAX Frontend
        $request->validate([
            'jenis_pesanan' => 'required|in:delivery,pickup',
            'total_tamu' => 'required|numeric', // Menampung nominal uang total belanja
            'items' => 'required|array',
            'alamat_pengiriman' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::id(); 
            $jenisPesanan = $request->jenis_pesanan; 
            $userId = auth()->guard('web')->id(); 
            $jenisPesanan = $request->jenis_pesanan; // 'delivery' atau 'pickup'

            // 1. Simpan data utama ke tabel 'reservasi'
            $reservasi = Reservasi::create([
                'pengguna_id'       => $userId,
                'jenis_pesanan'     => $jenisPesanan,
                'total_tamu'        => $request->total_tamu, // Total harga belanja disimpan di sini
                'status'            => 'menunggu', 
                
                // Field dine-in diset NULL karena ini transaksi online (delivery/pickup)
                'meja_id'           => null,
                'tanggal_reservasi' => null,
                'jam_mulai'         => null,
                'jam_selesai'       => null,
                
                // Menangkap alamat dinamis yang diinput pelanggan di keranjang belanja
                'alamat_pengiriman' => $jenisPesanan == 'delivery' ? $request->alamat_pengiriman : null,
                'ongkir'            => $jenisPesanan == 'delivery' ? 15000 : 0
            ]);

            // 2. Simpan item-item produk ke tabel 'detail_reservasi'
            foreach ($request->items as $item) {
                
                // Mengambil data harga menu langsung dari database agar aman dari manipulasi frontend
                $menu = Menu::find($item['menu_id']);
                $hargaMenu = $menu ? $menu->harga : ($item['subtotal'] / $item['jumlah']); 

                DetailReservasi::create([
                    'reservasi_id'          => $reservasi->id,
                    'menu_id'               => $item['menu_id'],
                    'jumlah'                => $item['jumlah'],
                    'subtotal'              => $item['subtotal'],
                    'harga_saat_reservasi'  => $hargaMenu 
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'reservasi_id' => $reservasi->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses checkout: ' . $e->getMessage()
            ], 500);
        }
    }     

    /**
     * Menyelesaikan pesanan dan memberikan reward poin kepada pelanggan
     */
    public function selesaikanPesanan($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => 'selesai']);

        // Hitung poin: Setiap Kelipatan Rp 10.000 dapat 1 poin
        $poinBaru = floor($reservasi->total_tamu / 10000);

        // Tambah poin ke pengguna yang bersangkutan jika akun terverifikasi cocok
        $user = Auth::user();
        // Tambah poin ke user via relasi auth atau manual (sesuaikan nama kolom 'poin' di tabel pengguna)
        $user = auth()->guard('web')->user();
        if ($user && $reservasi->pengguna_id == $user->id) {
            $user->increment('poin', $poinBaru);
        }

        return redirect()->back()->with('success', 'Pesanan selesai! Anda berhasil mendapatkan ' . $poinBaru . ' poin Roastory.');
    }
}