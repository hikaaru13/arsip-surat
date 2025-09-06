<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Category;              // <— tambahkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;       // <— tambahkan

class SuratController extends Controller
{
    // LIST + SEARCH (judul contains)
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $surats = Surat::query()
            ->when($q !== '', fn($w) => $w->where('judul', 'like', "%{$q}%"))
            ->orderByDesc('waktu_pengarsipan')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('surat.index', compact('surats', 'q'));
    }

    // FORM TAMBAH
    public function create()
    {
        // Ambil daftar kategori dari DB; fallback ke 4 default jika kosong
        $kategoriOptions = Category::orderBy('nama')->pluck('nama')->all();
        if (empty($kategoriOptions)) {
            $kategoriOptions = ['Undangan','Pengumuman','Nota Dinas','Pemberitahuan'];
        }

        return view('surat.create', compact('kategoriOptions'));
    }

    // SIMPAN + UPLOAD PDF
    public function store(Request $request)
    {
        $kategoriOptions = Category::orderBy('nama')->pluck('nama')->all();
        if (empty($kategoriOptions)) {
            $kategoriOptions = ['Undangan','Pengumuman','Nota Dinas','Pemberitahuan'];
        }

        $data = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat',
            'kategori'    => ['required', Rule::in($kategoriOptions)],
            'judul'       => 'required|string|max:255',
            'file'        => 'required|file|mimes:pdf|max:20480', // PDF ONLY
        ]);

        $safeName = time().'_'.Str::slug($data['judul']).'.pdf';
        $path = $request->file('file')->storeAs('surat', $safeName, 'public');

        Surat::create([
            'nomor_surat'       => $data['nomor_surat'],
            'kategori'          => $data['kategori'],
            'judul'             => $data['judul'],
            'waktu_pengarsipan' => now(),
            'file_path'         => $path,
        ]);

        return redirect()->route('surat.index')->with('ok', 'Data berhasil disimpan');
    }

    // DETAIL / LIHAT >>
    public function show(Surat $surat)
    {
        return view('surat.show', compact('surat'));
    }

    // FORM UBAH
    public function edit(Surat $surat)
    {
        $kategoriOptions = Category::orderBy('nama')->pluck('nama')->all();
        if (empty($kategoriOptions)) {
            $kategoriOptions = ['Undangan','Pengumuman','Nota Dinas','Pemberitahuan'];
        }

        return view('surat.edit', compact('surat', 'kategoriOptions'));
    }

    // UPDATE DATA + (opsional) ganti file
    public function update(Request $request, Surat $surat)
    {
        $kategoriOptions = Category::orderBy('nama')->pluck('nama')->all();
        if (empty($kategoriOptions)) {
            $kategoriOptions = ['Undangan','Pengumuman','Nota Dinas','Pemberitahuan'];
        }

        $data = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat,'.$surat->id,
            'kategori'    => ['required', Rule::in($kategoriOptions)],
            'judul'       => 'required|string|max:255',
            'file'        => 'nullable|file|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('file')) {
            if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $safeName = time().'_'.Str::slug($data['judul']).'.pdf';
            $surat->file_path = $request->file('file')->storeAs('surat', $safeName, 'public');
        }

        $surat->fill([
            'nomor_surat' => $data['nomor_surat'],
            'kategori'    => $data['kategori'],
            'judul'       => $data['judul'],
        ])->save();

        return redirect()->route('surat.index')->with('ok', 'Data berhasil disimpan');
    }

    // HAPUS (hapus DB + file)
    public function destroy(Request $request, Surat $surat)
    {
        if ($surat->file_path && Storage::disk('public')->exists($surat->file_path)) {
            Storage::disk('public')->delete($surat->file_path);
        }
        $id = $surat->id;
        $surat->delete();

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'id' => $id]);
        }
        return back()->with('ok', 'Surat terhapus.');
    }

    // UNDUH PDF
    public function download(Surat $surat)
    {
        if (!$surat->file_path || !Storage::disk('public')->exists($surat->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }
        $filename = Str::slug($surat->judul ?: 'surat').'.pdf';
        return Storage::disk('public')->download($surat->file_path, $filename);
    }
}
