<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Berita</title>
    <style>
        @page { margin: 90px 45px 70px 45px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; }

        header { position: fixed; top: -62px; left: 0; right: 0; border-bottom: 2px solid #0f172a; padding-bottom: 8px; }
        header .brand { font-size: 15px; font-weight: bold; color: #0f172a; }
        header .sub { font-size: 10px; color: #64748b; }

        footer { position: fixed; bottom: -42px; left: 0; right: 0; border-top: 1px solid #cbd5e1;
                 padding-top: 6px; font-size: 9px; color: #64748b; }
        footer table { width: 100%; }
        .pagenum:before { content: counter(page); }

        h1 { font-size: 20px; margin: 0 0 4px 0; color: #0f172a; }
        .ringkas { color: #64748b; margin-bottom: 14px; }

        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #0f172a; color: #ffffff; text-align: left; padding: 8px; font-size: 10px; }
        table.data td { padding: 8px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        table.data tr:nth-child(even) td { background: #f8fafc; }
        .judul { font-weight: bold; color: #0f172a; }
        .nowrap { white-space: nowrap; }
    </style>
</head>
<body>

<header>
    <div class="brand">Berita App</div>
    <div class="sub">Laporan daftar berita</div>
</header>

<footer>
    <table>
        <tr>
            <td>Dicetak {{ now()->locale('id')->translatedFormat('d F Y, H:i') }}</td>
            <td style="text-align: right;">Halaman <span class="pagenum"></span></td>
        </tr>
    </table>
</footer>

<main>
    <h1>Daftar Berita</h1>
    <div class="ringkas">Total {{ $beritas->count() }} berita, diurutkan dari yang terbaru.</div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 28px;">No</th>
                <th style="width: 80px;">Tanggal</th>
                <th>Judul</th>
                <th style="width: 80px;">Kategori</th>
                <th style="width: 110px;">Penulis</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($beritas as $i => $b)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="nowrap">{{ \Carbon\Carbon::parse($b->tanggal)->locale('id')->translatedFormat('d M Y') }}</td>
                <td>
                    <div class="judul">{{ $b->judul }}</div>
                    <div style="color: #64748b;">{{ \Illuminate\Support\Str::limit(strip_tags($b->isi), 90) }}</div>
                </td>
                <td>{{ $b->kategori->nama }}</td>
                <td>{{ $b->user->name }}</td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align: center; padding: 20px; color: #64748b;">Belum ada berita.</td></tr>
        @endforelse
        </tbody>
    </table>
</main>

</body>
</html>
