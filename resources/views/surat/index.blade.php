@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-3">Arsip Surat</h5>
    <p class="text-muted small mb-3">
      Ketik kata pada kolom di bawah lalu klik <b>Cari</b>. Tabel akan menampilkan hanya surat dengan
      judul yang mengandung kata tersebut. #ProductiveBukanProlog 😄
    </p>

    <form method="GET" action="{{ route('surat.index') }}" class="row g-2 mb-3">
      <div class="col-md-6">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari judul surat...">
      </div>
      <div class="col-auto">
        <button class="btn btn-primary">Cari</button>
      </div>
      @if($q !== '')
      <div class="col-auto">
        <a href="{{ route('surat.index') }}" class="btn btn-outline-secondary">Reset</a>
      </div>
      @endif
    </form>

    <div class="table-responsive">
      <table class="table table-sm align-middle table-striped table-fixed">
        <thead class="table-light">
          <tr>
            <th style="width: 16rem;">Nomor Surat</th>
            <th style="width: 10rem;">Kategori</th>
            <th>Judul</th>
            <th style="width: 12rem;">Waktu Pengarsipan</th>
            <th style="width: 13rem;">Aksi</th>
          </tr>
        </thead>
        <tbody id="rows">
          @forelse($surats as $s)
          <tr id="row-{{ $s->id }}">
            <td class="text-truncate">{{ $s->nomor_surat }}</td>
            <td class="text-truncate">{{ $s->kategori }}</td>
            <td class="text-truncate" title="{{ $s->judul }}">{{ $s->judul }}</td>
            <td>{{ optional($s->waktu_pengarsipan)->format('Y-m-d H:i') }}</td>
            <td>
              <button class="btn btn-danger btn-xs btn-delete" data-url="{{ route('surat.destroy',$s) }}">Hapus</button>
              <a class="btn btn-warning btn-xs" href="{{ route('surat.download',$s) }}">Unduh</a>
              <a class="btn btn-primary btn-xs" href="{{ route('surat.show',$s) }}">Lihat >></a>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{ $surats->links() }}

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
          <div class="modal-header border-0">
            <h5 class="modal-title">Alert</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin menghapus arsip surat ini?
          </div>
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
  // Modal & state
  let pendingDelete = { url: null, rowId: null };

  const token   = document.querySelector('meta[name="csrf-token"]').content;
  const modalEl = document.getElementById('confirmDeleteModal');
  const modal   = new bootstrap.Modal(modalEl);

  // Klik tombol Hapus -> tampilkan modal
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const tr = this.closest('tr');
      pendingDelete.url   = this.dataset.url;
      pendingDelete.rowId = tr ? tr.id : null; // contoh: "row-12"
      modal.show();
    });
  });

  // Klik "Ya!" -> DELETE ke server, hapus baris dari tampilan
  document.getElementById('btn-confirm-yes').addEventListener('click', function () {
    if (!pendingDelete.url) return;

    fetch(pendingDelete.url, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
    })
    .then(r => r.ok ? r.json() : Promise.reject(r))
    .then(json => {
      if (json.ok) {
        const tr = document.getElementById(pendingDelete.rowId) 
                || document.getElementById('row-' + json.id); // fallback
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

  // "Batal" / tutup modal -> tidak ada perubahan
  modalEl.addEventListener('hidden.bs.modal', () => {
    pendingDelete = { url: null, rowId: null };
  });
</script>
@endsection
