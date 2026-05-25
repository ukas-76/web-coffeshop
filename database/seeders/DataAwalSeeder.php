<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DataAwalSeeder extends Seeder
{
    public function run()
    {
        // 1. Data Tingkat Pelanggan
        DB::table('tingkat_pelanggan')->insert([
            ['nama' => 'Bronze', 'poin_minimal' => 0, 'persentase_diskon' => 0.00],
            ['nama' => 'Silver', 'poin_minimal' => 100, 'persentase_diskon' => 5.00],
            ['nama' => 'Gold', 'poin_minimal' => 300, 'persentase_diskon' => 10.00],
        ]);

        // 2. Data Kategori Menu
        DB::table('kategori_menu')->insert([
            ['nama' => 'Coffee'],
            ['nama' => 'Non-Coffee'],
            ['nama' => 'Makanan Utama'],
            ['nama' => 'Cemilan'],
        ]);

        // 3. Data Meja Awal (Agar bisa langsung tes fitur reservasi)
        DB::table('meja')->insert([
            ['nomor_meja' => 'T-01', 'kapasitas' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'T-02', 'kapasitas' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'VIP-01', 'kapasitas' => 6, 'status' => 'tersedia'],
        ]);

        // 4. Akun Admin Utama
        DB::table('pengguna')->insert([
            'tingkat_pelanggan_id' => null, // Admin tidak punya tier
            'nama' => 'Admin Coffee Shop',
            'email' => 'admin@coffeeshop.com',
            'password' => Hash::make('password123'), // Password untuk login
            'nomor_telepon' => '081234567890',
            'role' => 'admin',
            'poin' => 0,
        ]);
    }
}