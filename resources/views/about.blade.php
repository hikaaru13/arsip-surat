@extends('layouts.app')

@section('content')
@php
  // ambil data dari .env (fallback aman)
  $name     = env('ABOUT_NAME', 'Nama Anda');
  $nim      = env('ABOUT_NIM', 'NIM-Anda');
  $dateRaw  = env('APP_CREATED_AT', now()->toDateString());

  // foto: pakai storage/profile.jpg jika ada; jika tidak, pakai avatar otomatis
  $disk     = \Illuminate\Support\Facades\Storage::disk('public');
  $photoUrl = $disk->exists('profile.jpg')
              ? $disk->url('profile.jpg')
              : 'https://ui-avatars.com/api/?name='.urlencode($name).'&size=280&background=EEF2FF&color=1D4ED8';

  // format tanggal cantik (Indonesia)
  try {
    $tanggal = \Carbon\Carbon::parse($dateRaw)->locale('id')->translatedFormat('d F Y');
  } catch (\Exception $e) {
    $tanggal = $dateRaw;
  }
@endphp

<div class="card">
  <div class="card-body">
    <h5 class="card-title mb-3">About</h5>

    <div class="d-flex flex-wrap align-items-start gap-4">
      <img src="{{ $photoUrl }}" alt="Foto {{ $name }}"
           class="rounded-circle"
           style="width:160px;height:160px;object-fit:cover;box-shadow:0 2px 12px rgba(0,0,0,.12)">

      <div class="flex-grow-1">
        <dl class="row mb-0">
          <dt class="col-sm-4 col-lg-3">Nama</dt>
          <dd class="col-sm-8 col-lg-9">{{ $name }}</dd>

          <dt class="col-sm-4 col-lg-3">NIM</dt>
          <dd class="col-sm-8 col-lg-9">{{ $nim }}</dd>

          <dt class="col-sm-4 col-lg-3">Tanggal Pembuatan</dt>
          <dd class="col-sm-8 col-lg-9">{{ $tanggal }}</dd>
        </dl>

        <p class="text-muted mt-3">
          Aplikasi Arsip Surat — Laravel + Bootstrap. Data yang tampil di sini diambil dari
          file <code>.env</code> dan foto di <code>storage/app/public/profile.jpg</code>.
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
