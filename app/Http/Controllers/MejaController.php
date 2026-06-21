<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja; 
use Illuminate\Support\Facades\File;

class MejaController extends Controller
{
    public function index()
    {
        $allMeja = Meja::orderBy('nomor_meja', 'asc')->get();
        return view('admin.manajemen_meja', compact('allMeja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:20|unique:meja,nomor_meja', // unique ke tabel meja
            'kapasitas' => 'required|integer|min:1',
            'min_dp' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipesan,rusak',
            'gambar_lokasi' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_lokasi')) {
            $file = $request->file('gambar_lokasi');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/meja'), $nama_file);
            $data['gambar_lokasi'] = 'uploads/meja/' . $nama_file;
        }

        Meja::create($data);

        return redirect()->back()->with('success', 'Meja baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);

        $request->validate([
            'nomor_meja' => 'required|string|max:20|unique:meja,nomor_meja,' . $id,
            'kapasitas' => 'required|integer|min:1',
            'min_dp' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipesan,rusak',
            'gambar_lokasi' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_lokasi')) {
            if ($meja->gambar_lokasi && File::exists(public_path($meja->gambar_lokasi))) {
                File::delete(public_path($meja->gambar_lokasi));
            }

            $file = $request->file('gambar_lokasi');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/meja'), $nama_file);
            $data['gambar_lokasi'] = 'uploads/meja/' . $nama_file;
        }

        $meja->update($data);

        return redirect()->back()->with('success', 'Data meja berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $meja = Meja::findOrFail($id);
        
        if ($meja->gambar_lokasi && File::exists(public_path($meja->gambar_lokasi))) {
            File::delete(public_path($meja->gambar_lokasi));
        }

        $meja->delete();
        return redirect()->back()->with('success', 'Meja berhasil dihapus!');
    }
}