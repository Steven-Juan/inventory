<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        :root { color-scheme: light; --ink:#17212b; --muted:#637083; --line:#d9e2ec; --paper:#ffffff; --wash:#f4f7f9; --blue:#155eef; --green:#147d64; --red:#c2410c; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: Arial, Helvetica, sans-serif; background:var(--wash); color:var(--ink); }
        header { background:#0f2437; color:#fff; }
        .bar { max-width:1180px; margin:0 auto; padding:18px 20px; display:flex; align-items:center; justify-content:space-between; gap:18px; }
        .brand { font-weight:700; font-size:20px; }
        nav { display:flex; gap:8px; flex-wrap:wrap; }
        nav a { color:#dbeafe; text-decoration:none; padding:8px 11px; border-radius:6px; }
        nav a.active, nav a:hover { background:#1d4ed8; color:#fff; }
        main { max-width:1180px; margin:0 auto; padding:24px 20px 44px; }
        h1 { margin:0 0 8px; font-size:28px; }
        h2 { margin:0 0 14px; font-size:18px; }
        p { color:var(--muted); }
        .grid { display:grid; gap:18px; }
        .grid.two { grid-template-columns: minmax(0, 1fr) minmax(320px, .7fr); }
        .grid.four { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .panel, .metric { background:var(--paper); border:1px solid var(--line); border-radius:8px; padding:18px; }
        .metric strong { display:block; font-size:26px; margin-top:6px; }
        .status { margin:0 0 16px; padding:12px 14px; background:#dcfce7; border:1px solid #86efac; border-radius:6px; color:#14532d; }
        .errors { margin:0 0 16px; padding:12px 14px; background:#fff7ed; border:1px solid #fdba74; border-radius:6px; color:#7c2d12; }
        form { display:grid; gap:12px; }
        label { display:grid; gap:6px; font-size:13px; font-weight:700; color:#334155; }
        input, select, textarea { width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:10px 11px; font:inherit; background:#fff; color:var(--ink); }
        textarea { min-height:88px; resize:vertical; }
        button, .button { border:0; border-radius:6px; padding:10px 13px; background:var(--blue); color:#fff; font-weight:700; cursor:pointer; text-decoration:none; display:inline-flex; justify-content:center; align-items:center; gap:8px; }
        .button.secondary { background:#334155; }
        .button.green, button.green { background:var(--green); }
        .actions { display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        table { width:100%; border-collapse:collapse; background:#fff; }
        th, td { text-align:left; border-bottom:1px solid var(--line); padding:10px 8px; vertical-align:top; }
        th { font-size:12px; color:#475569; text-transform:uppercase; letter-spacing:0; }
        .badge { display:inline-block; padding:4px 8px; border-radius:999px; background:#e2e8f0; font-size:12px; font-weight:700; }
        .badge.low { background:#fed7aa; color:#7c2d12; }
        .badge.ok { background:#bbf7d0; color:#14532d; }
        .list { display:grid; gap:12px; }
        .message { border:1px solid var(--line); border-radius:8px; padding:14px; background:#fff; }
        .message.unread { border-left:5px solid var(--blue); }
        .pagination { margin-top:14px; }
        @media (max-width: 820px) { .grid.two, .grid.four { grid-template-columns:1fr; } .bar { align-items:flex-start; flex-direction:column; } table { font-size:14px; } }
        @media print { header, .no-print { display:none; } body { background:#fff; } main { padding:0; max-width:none; } .panel { border:0; padding:0; } }
    </style>
</head>
<body>
<header>
    <div class="bar">
        <div class="brand">Inventory Steven</div>
        <nav>
            <a href="{{ route('inventory.index') }}" class="{{ request()->is('pencatatan*') ? 'active' : '' }}">Pencatatan</a>
            <a href="{{ route('reports.index') }}" class="{{ request()->is('laporan*') ? 'active' : '' }}">Cetak Laporan</a>
            <a href="{{ route('communication.index') }}" class="{{ request()->is('komunikasi*') ? 'active' : '' }}">Notif & Komunikasi</a>
        </nav>
    </div>
</header>
<main>
    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>

