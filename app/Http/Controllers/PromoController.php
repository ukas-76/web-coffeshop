<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use Illuminate\Support\Facades\File;

class PromoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'badge_teks' => 'required|string|max:255',
            'link_aksi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        // Logika upload gambar banner promo
        if ($request->hasFile('gambar')) {
            $namaGambar = time() . '_promo.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/promo'), $namaGambar);
            $data['gambar'] = 'uploads/promo/' . $namaGambar;
        }

        Promo::create($data);

        return redirect()->back()->with('success', 'Promo berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required',
        'badge_teks' => 'required|string|max:255',
        'link_aksi' => 'required|string|max:255',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $promo = Promo::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($promo->gambar && File::exists(public_path($promo->gambar))) {
            File::delete(public_path($promo->gambar));
        }
        
        $namaGambar = time() . '_promo.' . $request->gambar->extension();
        $request->gambar->move(public_path('uploads/promo'), $namaGambar);
        $data['gambar'] = 'uploads/promo/' . $namaGambar;
    }

    $promo->update($data);
    return redirect()->back()->with('success', 'Promo berhasil diperbarui!');
}

public function destroy($id)
{
    $promo = Promo::findOrFail($id);
    
    // Hapus file gambar dari public folder
    if ($promo->gambar && File::exists(public_path($promo->gambar))) {
        File::delete(public_path($promo->gambar));
    }

    $promo->delete();
    return redirect()->back()->with('success', 'Promo berhasil dihapus!');
}

}