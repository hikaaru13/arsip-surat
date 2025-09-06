@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-1">Arsip Surat &raquo; Ubah</h5>

    <form method="POST" action="{{ route('surat.update', $surat) }}" enctype="multipart/form-data">
      @include('surat._form', [
        'surat' => $surat,
        'isEdit' => true,
        'kategoriOptions' => $kategoriOptions,
        'showManageKategori' => true
      ])
    </form>
  </div>
</div>
@endsection
