<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    // Sesuaikan bagian ini
protected $signature = 'make:admin {email} {password}'; 
protected $description = 'Membuat akun admin baru';

public function handle()
{
    \App\Models\User::create([
        'nama' => 'Admin Baru',
        'email' => $this->argument('email'),
        'password' => \Illuminate\Support\Facades\Hash::make($this->argument('password')),
        'role' => 'admin',
    ]);
    $this->info('Admin berhasil dibuat!');
}
}
