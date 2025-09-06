@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-1">Arsip Surat &raquo; Unggah</h5>
    <p class="text-muted small mb-3">
      Unggah surat yang telah terbit pada form ini untuk diarsipkan. <br>
      <strong>Catatan:</strong> gunakan file berformat PDF.
    </p>

    <form method="POST" action="{{ route('surat.store') }}" enctype="multipart/form-data" class="row g-3">
      @csrf

      <div class="col-md-6">
        <label class="form-label">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}" class="form-control" required>
        @error('nomor_surat')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">Kategori</label>
        <select name="kategori" class="form-select" required>
          <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>-- Pilih --</option>
          @foreach (['Undangan','Pengumuman','Nota Dinas','Pemberitahuan'] as $opt)
            <option value="{{ $opt }}" {{ old('kategori')===$opt ? 'selected' : '' }}>{{ $opt }}</option>
          @endforeach
        </select>
        @error('kategori')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>

      <div class="col-md-12">
        <label class="form-label">Judul</label>
        <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
        @error('judul')<div class="text-danger small">{{ $message }}</div>@enderror
      </div>

      <div class="col-md-8">
        <label class="form-label">File Surat (PDF)</label>
        <input type="file" name="file" accept="application/pdf" class="form-control" required>
        @error('file')<div class="text-danger small">{{ $message }}</div>@enderror
        <div class="form-text">Unggah berkas PDF surat.</div>
      </div>

      <div class="col-12">
        <a href="{{ route('surat.index') }}" class="btn btn-outline-secondary">&laquo; Kembali</a>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
