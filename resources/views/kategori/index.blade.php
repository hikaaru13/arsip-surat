@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-3">Kategori Surat</h5>
    <p class="text-muted small mb-3">
      Berikut ini kategori yang bisa digunakan untuk melabeli surat. Klik <b>Tambah</b> untuk menambah kategori baru.
    </p>

    <form method="GET" action="{{ route('kategori.index') }}" class="row g-2 mb-3">
      <div class="col-md-6">
        <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Cari kategori...">
      </div>
      <div class="col-auto">
        <button class="btn btn-primary">Cari</button>
      </div>
      @if(($q ?? '') !== '')
      <div class="col-auto">
        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Reset</a>
      </div>
      @endif
      <div class="col-auto ms-auto">
        <a href="{{ route('kategori.create') }}" class="btn btn-success">[ + ] Tambah Kategori Baru..</a>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-sm align-middle table-striped">
        <thead class="table-light">
          <tr>
            <th style="width: 6rem;">ID</th>
            <th style="width: 18rem;">Nama Kategori</th>
            <th>Keterangan</th>
            <th style="width: 12rem;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($kategoris as $k)
          <tr id="row-{{ $k->id }}">
            <td>{{ $k->id }}</td>
            <td class="text-truncate">{{ $k->nama }}</td>
            <td class="text-truncate">{{ $k->keterangan }}</td>
            <td>
              <button class="btn btn-danger btn-xs btn-delete" data-url="{{ route('kategori.destroy', $k) }}">Hapus</button>
              <a href="{{ route('kategori.edit', $k) }}" class="btn btn-primary btn-xs">Edit</a>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{ $kategoris->links() }}

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
          <div class="modal-header border-0">
            <h5 class="modal-title">Alert</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">Apakah Anda yakin ingin menghapus kategori ini?</div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger" id="btn-confirm-yes">Ya!</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
  let pendingDelete = { url: null, rowId: null };
  const token   = document.querySelector('meta[name="csrf-token"]').content;
  const modalEl = document.getElementById('confirmDeleteModal');
  const modal   = new bootstrap.Modal(modalEl);

  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const tr = this.closest('tr');
      pendingDelete.url   = this.dataset.url;
      pendingDelete.rowId = tr ? tr.id : null;
      modal.show();
    });
  });

  document.getElementById('btn-confirm-yes').addEventListener('click', function () {
    if (!pendingDelete.url) return;
    fetch(pendingDelete.url, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(r => r.ok ? r.json() : Promise.reject(r))
    .then(json => {
      if (json.ok) {
        const tr = document.getElementById(pendingDelete.rowId);
        if (tr) tr.remove();
      } else {
        alert(json.message || 'Gagal menghapus.');
      }
    })
    .catch(() => alert('Terjadi kesalahan saat menghapus.'))
    .finally(() => {
      pendingDelete = { url: null, rowId: null };
      modal.hide();
    });
  });

  modalEl.addEventListener('hidden.bs.modal', () => {
    pendingDelete = { url: null, rowId: null };
  });
</script>
@endsection
