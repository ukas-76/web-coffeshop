<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Reservasi;
// Pastikan nama model Detail Reservasi kamu sudah di-import (sesuaikan jika ada perbedaan huruf kapital)
use App\Models\DetailReservasi; 

class PesananController extends Controller
{
    /**
     * Menampilkan halaman Menu Pesanan Online (order.blade.php)
     */
    public function order()
    {
        // LOGIKA DIPERBAIKI: Mengambil menu yang status ketersediaannya aktif (bernilai 1)
        $daftarMenu = Menu::where('tersedia', '1')->get();

        return view('order', compact('daftarMenu'));
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
     * KODE BARU: Memproses checkout dari Keranjang Belanja Online (Delivery / Pickup)
     * dan memasukkannya langsung ke dalam tabel tunggal 'reservasi'
     */
public function prosesCheckout(Request $request)
    {
        try {
            $userId = auth()->guard('web')->id(); 
            $jenisPesanan = $request->jenis_pesanan; // 'delivery' atau 'pickup'

            // Simpan data utama ke tabel 'reservasi'
            $reservasi = Reservasi::create([
                'pengguna_id'       => $userId,
                'jenis_pesanan'     => $jenisPesanan,
                'total_tamu'        => $request->total_tamu,
                'status'            => 'selesai', 
                
                // Kolom dine-in diset NULL agar sesuai dengan struktur order online kamu
                'meja_id'           => null,
                'tanggal_reservasi' => null,
                'jam_mulai'         => null,
                'jam_selesai'       => null,
                
                'alamat_pengiriman' => $jenisPesanan == 'delivery' ? 'Jl. Merdeka No. 10' : null,
                'ongkir'            => $jenisPesanan == 'delivery' ? 15000 : 0
            ]);

            // Simpan item-item produk ke tabel 'detail_reservasi'
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    
                    // Mengambil data harga menu langsung dari database agar aman dan akurat
                    $menu = Menu::find($item['menu_id']);
                    $hargaMenu = $menu ? $menu->harga : ($item['subtotal'] / $item['jumlah']); 

                    DetailReservasi::create([
                        'reservasi_id'          => $reservasi->id,
                        'menu_id'               => $item['menu_id'],
                        'jumlah'                => $item['jumlah'],
                        'subtotal'              => $item['subtotal'],
                        // TAMBAHKAN BARIS INI: Mengisi kolom wajib sesuai struktur database kamu
                        'harga_saat_reservasi'  => $hargaMenu 
                    ]);

                    
                }
            }

            return response()->json([
                'success' => true,
                'reservasi_id' => $reservasi->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }     

    /**
     * Menyelesaikan pesanan dan memberikan reward poin kepada pelanggan
     */
    public function selesaikanPesanan($id)
    {
        // Mengubah pencarian dari model Pesanan ke model Reservasi
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => 'selesai']);

        // Hitung poin: Setiap Kelipatan Rp 10.000 dapat 1 poin (menggunakan total_tamu sebagai total_harga)
        $poinBaru = floor($reservasi->total_tamu / 10000);

        // Tambah poin ke user via relasi auth atau manual (sesuaikan nama kolom 'poin' di tabel pengguna)
        $user = auth()->guard('web')->user();
        if ($user && $reservasi->pengguna_id == $user->id) {
            $user->increment('poin', $poinBaru);
        }

        return redirect()->back()->with('success', 'Pesanan selesai, Anda mendapatkan ' . $poinBaru . ' poin.');
    }
}