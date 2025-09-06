@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-1">Kategori Surat &raquo; Tambah</h5>
    <p class="text-muted small mb-3">
      Tambahkan data kategori. <em>ID akan terisi otomatis saat disimpan.</em>
    </p>
    <form method="POST" action="{{ route('kategori.store') }}">
      @include('kategori._form')
    </form>
  </div>
</div>
@endsection
