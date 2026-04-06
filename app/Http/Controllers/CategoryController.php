<?php

namespace App\Http\Controllers; // Pastikan ini benar

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Kategori Berhasil Ditambah!');
    }
    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($id);
    $category->update([
        'name' => $request->name,
        'description' => $request->description
    ]);

    return redirect()->back()->with('success', 'Kategori Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori Berhasil Dihapus!');
    }
}