@csrf
@if(!empty($isEdit)) @method('PUT') @endif

<div class="row g-3">
  {{-- ID (Auto Increment) --}}
  <div class="col-md-3">
    <label class="form-label">ID (Auto Increment)</label>
    <input type="text" class="form-control" value="{{ $kategori->id ?? 'Auto' }}" readonly>
  </div>

  <div class="col-md-6">
    <label class="form-label">Nama Kategori</label>
    <input type="text" name="nama" class="form-control"
           value="{{ old('nama', $kategori->nama ?? '') }}" required>
    @error('nama')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <label class="form-label">Keterangan</label>
    <textarea name="keterangan" rows="3" class="form-control"
      placeholder="Keterangan singkat kategori">{{ old('keterangan', $kategori->keterangan ?? '') }}</textarea>
    @error('keterangan')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">&laquo; Kembali</a>
    <button class="btn btn-primary">Simpan</button>
  </div>
</div>
