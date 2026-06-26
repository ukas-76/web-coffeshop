<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::updateOrCreate(
            ['kunci' => 'google_maps_embed_url'],
            ['nilai' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24037562085!2d106.74837583696803!3d-6.22974649774643!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x100c5e82dd4b820!2sJakarta!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid']
        );
    }
}
