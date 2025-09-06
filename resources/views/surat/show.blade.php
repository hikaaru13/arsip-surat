@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-3">Arsip Surat &raquo; Lihat</h5>

    <div class="mb-3">
      <div><strong>Nomor:</strong> {{ $surat->nomor_surat }}</div>
      <div><strong>Kategori:</strong> {{ $surat->kategori }}</div>
      <div><strong>Judul:</strong> {{ $surat->judul }}</div>
      <div><strong>Waktu Unggah:</strong> {{ optional($surat->waktu_pengarsipan)->format('Y-m-d H:i') }}</div>
    </div>

    {{-- Viewer PDF --}}
    @if($surat->file_path && Storage::disk('public')->exists($surat->file_path))
      <div class="mb-3" style="border:1px solid #d9d9d9; border-radius:.5rem; overflow:hidden;">
        <iframe
          src="{{ Storage::url($surat->file_path) }}"
          width="100%" height="600"
          style="border:0;"
          title="Pratinjau PDF">
        </iframe>
      </div>
    @else
      <div class="alert alert-warning">File PDF tidak ditemukan.</div>
    @endif

    <div class="d-flex gap-2">
      <a href="{{ route('surat.index') }}" class="btn btn-outline-secondary">&laquo;&laquo; Kembali</a>
      <a href="{{ route('surat.download', $surat) }}" class="btn btn-warning">Unduh</a>
      {{-- Opsional: tombol edit/ganti file --}}
      <a href="{{ route('surat.edit', $surat) }}" class="btn btn-primary">Edit/Ganti File</a>
    </div>
  </div>
</div>
@endsection
