<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // LIST + SEARCH
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $kategoris = Category::query()
            ->when($q !== '', fn ($w) =>
                $w->where(function ($s) use ($q) {
                    $s->where('nama', 'like', "%{$q}%")
                    ->orWhere('keterangan', 'like', "%{$q}%");
                })
            )
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategoris', 'q'));
    }


    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'       => 'required|string|max:100|unique:categories,nama',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Category::create($data);
        return redirect()->route('kategori.index')->with('ok', 'Data berhasil disimpan');
    }

    public function edit(Category $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Category $kategori)
    {
        $data = $request->validate([
            'nama'       => 'required|string|max:100|unique:categories,nama,'.$kategori->id,
            'keterangan' => 'nullable|string|max:255',
        ]);

        $kategori->update($data);
        return redirect()->route('kategori.index')->with('ok', 'Data berhasil disimpan');
    }

    public function destroy(Request $request, Category $kategori)
    {
        $id = $kategori->id;
        $kategori->delete();

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'id' => $id]);
        }
        return back()->with('ok', 'Kategori terhapus.');
    }
}
