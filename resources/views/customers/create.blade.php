@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')

<div class="mb-4">
    <h3 class="page-heading">Tambah Pelanggan</h3>
    <p class="page-subtitle">Masukkan informasi pelanggan baru.</p>
</div>

<div class="custom-card">
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Pelanggan</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Nomor Telepon</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}">
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Alamat</label>
            <textarea name="address" class="form-control" rows="4">{{ old('address') }}</textarea>
        </div>

        <button class="btn btn-primary">
            <i class="fas fa-save me-2"></i> Simpan
        </button>

        <a href="{{ route('customers.index') }}" class="btn btn-light">Kembali</a>
    </form>
</div>

@endsection