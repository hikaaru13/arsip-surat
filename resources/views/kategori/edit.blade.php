@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-1">Kategori Surat &raquo; Edit</h5>
    <p class="text-muted small mb-3">
      Perbarui data kategori berikut. <em>ID bersifat otomatis dan tidak dapat diubah.</em>
    </p>
    <form method="POST" action="{{ route('kategori.update', $kategori) }}">
      @include('kategori._form', ['kategori' => $kategori, 'isEdit' => true])
    </form>
  </div>
</div>
@endsection
