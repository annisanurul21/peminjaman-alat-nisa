<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    // Menampilkan daftar alat
    public function index()
    {
        $tools = Tool::with('category')->get(); // Mengambil data alat beserta kategorinya
        $categories = Category::all(); // Untuk pilihan kategori di form tambah
        return view('admin.tools.index', compact('tools', 'categories'));
    }

    // Menyimpan data alat baru
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'code' => 'required|unique:tools',
            'name' => 'required',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Logika Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tools', 'public');
        }

        Tool::create($data);

        return redirect()->back()->with('success', 'Alat berhasil ditambahkan!');
    }

    // Memperbarui data alat
    public function update(Request $request, Tool $tool)
{
    $request->validate([
        'category_id' => 'required',
        'code'        => 'required|unique:tools,code,' . $tool->id,
        'name'        => 'required',
        'stock'       => 'required|numeric',
        'image'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $data = $request->all();

    // Jika ada upload gambar baru
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($tool->image) {
            \Storage::delete('public/' . $tool->image);
        }
        $data['image'] = $request->file('image')->store('tools', 'public');
    }

    $tool->update($data);

    return redirect()->route('admin.tools.index')->with('success', 'Alat berhasil diperbarui!');
}

    // Menghapus alat
    public function destroy($id)
    {
        $tool = Tool::findOrFail($id);
        
        // Hapus file gambarnya juga dari storage
        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }
        
        $tool                           ->delete();
        return redirect()->back()->with('success', 'Alat berhasil dihapus!');
    }
}