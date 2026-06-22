<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as Pengguna;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan Halaman Profil Pelanggan beserta Data Riwayat, Counter, & Tier Member
     */
    public function profile()
    {
        $user = Auth::user();

        // 1. Hitung Total Pesanan (Delivery & Pickup) yang statusnya 'selesai'
        $totalPesanan = Reservasi::where('pengguna_id', $user->id)
            ->whereIn('jenis_pesanan', ['delivery', 'pickup'])
            ->where('status', 'selesai')
            ->count();

        // 2. Hitung Reservasi Tuntas (Dine-in) yang statusnya 'selesai'
        $reservasiTuntas = Reservasi::where('pengguna_id', $user->id)
            ->where('jenis_pesanan', 'dine_in')
            ->where('status', 'selesai')
            ->count();

        /**
         * LOGIKA HITUNG POIN BERSANDARKAN NOMINAL BELANJA:
         * Mengambil total nominal belanja dari kolom 'total_tamu' karena nilai uang tersimpan di sana.
         * Tiap belanja Rp 10.000 mendapatkan 1 Poin.
         */
        $totalBelanjaSelesai = Reservasi::where('pengguna_id', $user->id)
            ->where('status', 'selesai')
            ->sum('total_harga'); 

        // Hitung poin (pembulatan ke bawah dengan floor)
        $poinRoastory = floor($totalBelanjaSelesai / 10000); 

        /**
         * LOGIKA PENENTUAN TIER MEMBER (OTOMATIS SESUAI POIN)
         * - Poin < 50    : Bronze Member
         * - Poin 50-149  : Silver Member
         * - Poin >= 150  : Gold Member
         */
        if ($poinRoastory >= 150) {
            $tierMember = 'Gold Member';
            $tierBadgeClass = 'tier-gold';
        } elseif ($poinRoastory >= 50) {
            $tierMember = 'Silver Member';
            $tierBadgeClass = 'tier-silver';
        } else {
            $tierMember = 'Bronze Member';
            $tierBadgeClass = 'tier-bronze';
        }

        // 3. Ambil riwayat Pesanan Online (Delivery & Pickup) untuk tabel
        $riwayatPesanan = Reservasi::where('pengguna_id', $user->id)
            ->whereIn('jenis_pesanan', ['delivery', 'pickup'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 4. Ambil riwayat Reservasi Meja (Dine-in) untuk tabel
        $riwayatReservasi = Reservasi::where('pengguna_id', $user->id)
            ->where('jenis_pesanan', 'dine_in')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile', compact(
            'user', 
            'totalPesanan', 
            'reservasiTuntas', 
            'poinRoastory', 
            'tierMember',
            'tierBadgeClass',
            'riwayatPesanan', 
            'riwayatReservasi'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Pengguna::where('id', $user->id)->update([
            'nama' => $request->name,
            'nomor_telepon' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Informasi pribadi berhasil diperbarui!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            Pengguna::where('id', $user->id)->update([
                'avatar' => $path
            ]);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto profil.');
    }
}