@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
    <div class="mb-6">
        <a href="{{ route('berita.index') }}" class="text-sm text-slate-500 hover:text-slate-900">&larr; Kembali ke daftar berita</a>
        <h1 class="text-2xl font-bold text-slate-900 mt-2">Edit berita</h1>
    </div>

    @include('berita._form', ['action' => route('berita.update', $berita), 'berita' => $berita])
@endsection