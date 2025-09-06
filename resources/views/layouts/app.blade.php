<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Arsip Surat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root { --sidebar-w: 220px; }
    body { background:#f7f8fa; }
    .app-wrap { min-height:100vh; display:flex; }
    .sidebar {
      width:var(--sidebar-w); background:#fff; border-right:1px solid #e5e7eb; padding:18px 14px; position:sticky; top:0; height:100vh;
    }
    .brand { font-weight:700; font-size:20px; margin-bottom:18px; }
    .nav-link {
      border-radius:10px; padding:.52rem .8rem; margin-bottom:6px; color:#334155;
    }
    .nav-link.active, .nav-link:hover { background:#eef2ff; color:#1d4ed8; }
    .content { flex:1; padding:22px; }
    .card { border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.04); }
    .btn-xs{ padding:.22rem .5rem; font-size:.8rem; border-radius:8px; }
    @media (max-width: 992px) {
      .sidebar{ position:static; height:auto; width:100%; border-right:0; border-bottom:1px solid #e5e7eb; }
      .app-wrap{ display:block; }
    }
  </style>
</head>
<body>

<div class="app-wrap">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="brand">Arsip Surat</div>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->routeIs('surat.*') ? 'active' : '' }}" href="{{ route('surat.index') }}">📁 Arsip</a>
      <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">🏷️ Kategori Surat</a>
      <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">ℹ️ About</a>
    </nav>

    <div class="mt-3">
      <a class="btn btn-outline-primary btn-sm w-100" href="{{ route('surat.create') }}">+ Arsipkan Surat..</a>
    </div>
  </aside>

  <!-- Main content -->
  <main class="content">
    @if(session('ok'))
      <div class="alert alert-success small">{{ session('ok') }}</div>
    @endif
    @yield('content')
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
