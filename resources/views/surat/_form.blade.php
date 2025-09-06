@php
  // Ambil dari controller; jika kosong, fallback ke default empat opsi
  $kategoriOptions = ($kategoriOptions ?? []) ?: ['Undangan','Pengumuman','Nota Dinas','Pemberitahuan'];
@endphp

@csrf
@if(isset($isEdit) && $isEdit) @method('PUT') @endif

<div class="row g-3">

  <div class="col-md-6">
    <label class="form-label">Nomor Surat</label>
    <input type="text" name="nomor_surat"
           value="{{ old('nomor_surat', $surat->nomor_surat ?? '') }}"
           class="form-control" required>
    @error('nomor_surat')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-4">
    <label class="form-label">Kategori</label>
    <div class="d-flex gap-2">
      <select name="kategori" class="form-select" required>
        <option value="" disabled {{ old('kategori', $surat->kategori ?? '')===''?'selected':'' }}>-- Pilih --</option>
        @foreach($kategoriOptions as $opt)
          <option value="{{ $opt }}" {{ old('kategori', $surat->kategori ?? '')===$opt ? 'selected' : '' }}>
            {{ $opt }}
          </option>
        @endforeach
      </select>
      @isset($showManageKategori)
        <a href="{{ route('kategori.index') }}" class="btn btn-outline-primary">Kelola</a>
      @endisset
    </div>
    @error('kategori')<div class="text-danger small">{{ $message }}</div>@enderror
    @if(empty($kategoriOptions))
      <div class="form-text">Belum ada kategori di database. Gunakan opsi bawaan atau tambahkan di menu <em>Kategori Surat</em>.</div>
    @endif
  </div>

  <div class="col-md-12">
    <label class="form-label">Judul</label>
    <input type="text" name="judul" value="{{ old('judul', $surat->judul ?? '') }}"
           class="form-control" required>
    @error('judul')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-8">
    <label class="form-label">File Surat (PDF)</label>
    <input type="file" name="file" accept="application/pdf" class="form-control" {{ !isset($isEdit)?'required':'' }}>
    @error('file')<div class="text-danger small">{{ $message }}</div>@enderror
    <div class="form-text">Gunakan file berformat PDF.</div>
    @isset($surat->file_path)
      <div class="small mt-1">File saat ini: <code>{{ $surat->file_path }}</code></div>
    @endisset
  </div>

  <div class="col-12">
    <a href="{{ route('surat.index') }}" class="btn btn-outline-secondary">&laquo; Kembali</a>
    <button class="btn btn-primary">Simpan</button>
  </div>
</div>
