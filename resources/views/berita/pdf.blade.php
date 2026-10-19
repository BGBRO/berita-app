<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $berita->judul }}</title>
    <style>
        @page { margin: 90px 55px 70px 55px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; line-height: 1.7; }

        header { position: fixed; top: -62px; left: 0; right: 0; border-bottom: 2px solid #0f172a; padding-bottom: 8px; }
        header .brand { font-size: 15px; font-weight: bold; color: #0f172a; }
        header .sub { font-size: 10px; color: #64748b; }

        footer { position: fixed; bottom: -42px; left: 0; right: 0; border-top: 1px solid #cbd5e1;
                 padding-top: 6px; font-size: 9px; color: #64748b; }
        footer table { width: 100%; }
        .pagenum:before { content: counter(page); }

        .kategori { display: inline-block; background: #f1f5f9; color: #334155; font-size: 10px;
                    padding: 3px 10px; border-radius: 4px; }
        h1 { font-size: 24px; line-height: 1.3; color: #0f172a; margin: 12px 0 10px 0; }
        .meta { font-size: 11px; color: #64748b; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0; margin-bottom: 16px; }
        .gambar { width: 100%; margin-bottom: 16px; }
        .isi { font-size: 13px; text-align: justify; }
    </style>
</head>
<body>

<header>
    <div class="brand">Berita App</div>
    <div class="sub">Salinan cetak berita</div>
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
    <span class="kategori">{{ $berita->kategori->nama }}</span>

    <h1>{{ $berita->judul }}</h1>

    <div class="meta">
        Ditulis oleh <strong>{{ $berita->user->name }}</strong>
        &nbsp;|&nbsp;
        {{ \Carbon\Carbon::parse($berita->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
    </div>

    @if ($gambar)
        <img src="{{ $gambar }}" class="gambar" alt="">
    @endif

    <div class="isi">{!! nl2br(e($berita->isi)) !!}</div>
</main>

</body>
</html>
