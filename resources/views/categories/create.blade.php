@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<div class="mb-4">
    <h3 class="page-heading">Tambah Kategori</h3>
    <p class="page-subtitle">Tambahkan kategori mainan baru.</p>
</div>

<div class="custom-card">
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Kategori</label>
            <input type="text" name="name" class="form-control"
                   placeholder="Contoh: Mainan Edukasi" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4"
                      placeholder="Deskripsi kategori">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Gambar Kategori</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Maksimal 2 MB.</small>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
            <a href="{{ route('categories.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
</div>

@endsection