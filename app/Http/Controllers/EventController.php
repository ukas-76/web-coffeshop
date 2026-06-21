<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\File;

class EventController extends Controller
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

        // Logika upload gambar banner event
        if ($request->hasFile('gambar')) {
            $namaGambar = time() . '_event.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/event'), $namaGambar);
            $data['gambar'] = 'uploads/event/' . $namaGambar;
        }

        Event::create($data);

        return redirect()->back()->with('success', 'Event berhasil ditambahkan!');
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

    $event = Event::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('gambar')) {
        if ($event->gambar && File::exists(public_path($event->gambar))) {
            File::delete(public_path($event->gambar));
        }
        
        $namaGambar = time() . '_event.' . $request->gambar->extension();
        $request->gambar->move(public_path('uploads/event'), $namaGambar);
        $data['gambar'] = 'uploads/event/' . $namaGambar;
    }

    $event->update($data);
    return redirect()->back()->with('success', 'Event berhasil diperbarui!');
}

public function destroy($id)
{
    $event = Event::findOrFail($id);
    
    if ($event->gambar && File::exists(public_path($event->gambar))) {
        File::delete(public_path($event->gambar));
    }

    $event->delete();
    return redirect()->back()->with('success', 'Event berhasil dihapus!');
}
}