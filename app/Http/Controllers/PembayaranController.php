<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Exception;

class PembayaranController extends Controller
{
    /**
     * Langkah 1: Fungsi awal saat user klik tombol bayar.
     * Membuat data di database dengan status pending, lalu men-generate Snap Token Midtrans.
     */
    public function prosesCheckout(Request $request)
    {
        // 1. Tangkap data SESUAI dengan name="..." di form reservasi.blade.php
        $userId = auth()->guard('web')->id() ?: 1;
        $mejaId = $request->input('mejaSelect');
        $tanggal = $request->input('tanggal');
        $jam = $request->input('jam');
        $jumlahOrang = $request->input('jumlah_orang'); // INI YANG BIKIN MENTAL SEBELUMNYA
        $totalBayar = $request->input('total_bayar') ?: 75000;
        $namaPemesan = $request->input('nama') ?: 'Pelanggan';
        $noWa = $request->input('no_whatsapp') ?: '';

        try {
           
            
            // 2. Simpan ke database
            $reservasi = \App\Models\Reservasi::create([
                'pengguna_id' => $userId, // <--- UBAH DI SINI
                'meja_id' => $mejaId,
                'jenis_pesanan' => 'dine_in',
                'tanggal_reservasi' => $tanggal,
                'jam_mulai' => $jam,
                'total_tamu' => $jumlahOrang, 
                'status' => 'menunggu', 
            ]);

            $orderId = 'TRX-' . time() . '-' . $userId;

            \App\Models\Pembayaran::create([
                'id_transaksi' => $orderId,
                'reservasi_id' => $reservasi->id,
                'total_bayar' => $totalBayar,
                'metode_pembayaran' => 'belum_dipilih', 
                'status' => 'belum_bayar',
            ]);

            // 3. Generate Token Midtrans
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalBayar,
                ],
                'customer_details' => [
                    'first_name' => $namaPemesan,
                    'phone' => $noWa,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // 4. LEMPAR KE HALAMAN PAYMENT
            return view('payment', compact('snapToken', 'orderId'));

        } catch (\Exception $e) {
            // Kalau misal kolom DB lu ada yang beda namanya, pesan errornya bakal muncul di layar
            return back()->with('error', 'Gagal menyimpan ke database: ' . $e->getMessage());
        }
    }

    /**
     * Langkah 2: Fungsi penangkap lemparan dari JavaScript onSuccess di Blade.
     * Mengubah status reservasi dan pembayaran menjadi lunas/diterima setelah pembayaran berhasil.
     */
    public function finishCheckout(Request $request)
    {
        $orderId = $request->query('order_id');
        $status = $request->query('status');
        $method = $request->query('method');

        // Jika status yang dibawa dari JavaScript adalah sukses
        if ($status == 'success') {
            // 1. Cari data pembayaran berdasarkan id_transaksi (Order ID)
            $pembayaran = Pembayaran::where('id_transaksi', $orderId)->first();

            if ($pembayaran) {
                // 2. Update status pembayaran menjadi lunas
                $pembayaran->update([
                    'status' => 'lunas',
                    'metode_pembayaran' => $method ?: 'qris'
                ]);

                // 3. Update status reservasi yang terhubung menjadi diterima
                if ($pembayaran->reservasi) {
                    $pembayaran->reservasi->update([
                        'status' => 'selesai'
                    ]);
                }
            }
        }

        // 4. Alihkan user ke halaman riwayat atau dashboard utama dengan notifikasi sukses
        return redirect('/')->with('success', 'Pembayaran sukses, reservasi kamu berhasil dicatat!');
    }
}   