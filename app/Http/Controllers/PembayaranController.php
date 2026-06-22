<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Exception;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    
    public function prosesCheckoutOnline(Request $request)
    {
        $userId = auth()->guard('web')->id() ?: 1;
        $jenisPesanan = $request->input('jenis_pesanan'); // pickup / delivery
        $totalBayar = $request->input('total_tamu'); // total dari javascript
        $alamat = $request->input('alamat_pengiriman');

        try {
            // 1. Simpan ke database Reservasi (dengan jenis_pesanan non dine_in)
            $reservasi = Reservasi::create([
                'pengguna_id' => $userId,
                'meja_id' => null, // Pesanan online tidak memilih meja
                'jenis_pesanan' => $jenisPesanan, // pickup / delivery
                'tanggal_reservasi' => now()->toDateString(),
                'jam_mulai' => now()->toTimeString(),
                'total_tamu' => null, // total harga disimpan ke sini menyesuaikan DB lama kamu
                'total_harga' => $totalBayar,
                'status' => 'menunggu', 
            ]);

            // Jika ada sistem detail item pesanan, kamu bisa menyimpannya di sini (misal: DetailPesanan::create)
            // foreach($request->input('items') as $item) { ... }

            $orderId = 'TRX-ONL-' . time() . '-' . $userId;

            // 2. Simpan ke database Pembayaran
            Pembayaran::create([
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
                    'gross_amount' => (int) $totalBayar,
                ],
                'customer_details' => [
                    'first_name' => auth()->user() ? auth()->user()->name : 'Pelanggan Online',
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // 4. Simpan data ke session sementara agar bisa dibaca di halaman /payment
            session(['snapToken' => $snapToken, 'orderId' => $orderId]);

            // Kembalikan respons sukses berupa JSON ke AJAX Fetch
            return response()->json([
                'success' => true,
                'redirect_url' => url('/payment')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

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
                'total_harga' => $totalBayar, 
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

    public function halamanPayment(Request $request)
    {
        // 1. Cek apakah ada data di session (jika dialihkan via POST redirect)
        $snapToken = session('snapToken');
        $orderId = session('orderId');

        // 2. Jika session kosong (user datang dari URL GET seperti di screenshot: ?amount=...&reservasi_id=...)
        if (!$snapToken) {
            $reservasiId = $request->query('reservasi_id');
            $amount = $request->query('amount');

            // Cari data reservasi di database
            $reservasi = \App\Models\Reservasi::find($reservasiId);

            if (!$reservasi) {
                return redirect('/')->with('error', 'Data pesanan/reservasi tidak ditemukan.');
            }

            // Cari apakah sudah ada data pembayaran di database
            $pembayaran = \App\Models\Pembayaran::where('reservasi_id', $reservasiId)->first();
            
            // Tentukan Order ID: pakai yang sudah ada, atau buat baru kalau belum tercatat
            $orderId = $pembayaran ? $pembayaran->id_transaksi : 'TRX-' . time() . '-' . $reservasi->pengguna_id;

            // Tentukan nominal bayar berdasarkan kolom baru total_harga atau fallback $amount
            if ($pembayaran) {
                $nominalBayar = $pembayaran->total_bayar;
            } else {
                $nominalBayar = ($reservasi->jenis_pesanan == 'dine_in') ? ($amount ?: 75000) : $reservasi->total_harga;
            }

            // 3. Konfigurasi ulang Midtrans secara on-the-fly untuk generate token baru
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $nominalBayar,
                ],
                'customer_details' => [
                    'first_name' => 'Pelanggan ' . ucfirst($reservasi->jenis_pesanan),
                ],
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                // Simpan ke tabel pembayaran sekalian jika belum ada data pembuatannya
                if (!$pembayaran) {
                    \App\Models\Pembayaran::create([
                        'id_transaksi' => $orderId,
                        'reservasi_id' => $reservasi->id,
                        'total_bayar' => $nominalBayar,
                        'metode_pembayaran' => 'belum_dipilih',
                        'status' => 'belum_bayar',
                    ]);
                }
            } catch (\Exception $e) {
                return redirect('/')->with('error', 'Gagal terhubung ke Midtrans: ' . $e->getMessage());
            }
        }

        // 4. Lempar data token dan order id dengan aman ke view payment.blade.php
        return view('payment', compact('snapToken', 'orderId'));
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

        session()->forget(['snapToken', 'orderId']);

        // 4. Alihkan user ke halaman riwayat atau dashboard utama dengan notifikasi sukses
        return redirect('/')->with('success', 'Pembayaran sukses, reservasi kamu berhasil dicatat!');
    }
}   