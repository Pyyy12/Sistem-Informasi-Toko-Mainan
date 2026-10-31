@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

<div class="mb-4">
    <h3 class="page-heading">Edit Produk</h3>
    <p class="page-subtitle">Perbarui informasi produk mainan.</p>
</div>

<div class="custom-card">

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-bold">Kode Produk</label>
                <input type="text" name="code" class="form-control"
                       value="{{ old('code', $product->code) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Produk</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Kategori</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Gambar Produk</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            @if($product->image)
                <div class="col-12">
                    <img src="{{ asset('storage/'.$product->image) }}"
                         width="120" class="rounded">
                </div>
            @endif

            <div class="col-md-6">
                <label class="form-label fw-bold">Harga Beli</label>
                <input type="number" name="purchase_price" class="form-control"
                       min="0" step="0.01"
                       value="{{ old('purchase_price', $product->purchase_price) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Harga Jual</label>
                <input type="number" name="selling_price" class="form-control"
                       min="0" step="0.01"
                       value="{{ old('selling_price', $product->selling_price) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Stok</label>
                <input type="number" name="stock" class="form-control"
                       min="0" value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Minimal Stok</label>
                <input type="number" name="minimum_stock" class="form-control"
                       min="0" value="{{ old('minimum_stock', $product->minimum_stock) }}" required>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

        </div>

        <hr class="my-4">

        <button class="btn btn-primary">
            <i class="fas fa-save me-2"></i> Update Produk
        </button>

        <a href="{{ route('products.index') }}" class="btn btn-light">Kembali</a>
    </form>

</div>

@endsection