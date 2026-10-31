@extends('layouts.app')

@section('title', 'Produk Mainan')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="page-heading">Produk Mainan</h3>
        <p class="page-subtitle">Kelola produk, harga jual, dan stok mainan.</p>
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Tambah Produk
    </a>
</div>

<div class="custom-card">

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari nama atau kode produk..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary flex-fill">
                <i class="fas fa-search me-1"></i> Cari
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>PRODUK</th>
                    <th>KATEGORI</th>
                    <th>HARGA BELI</th>
                    <th>HARGA JUAL</th>
                    <th>STOK</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" class="product-thumb">
                                @else
                                    <div class="product-thumb d-grid place-items-center">
                                        <i class="fas fa-cube text-muted"></i>
                                    </div>
                                @endif

                                <div>
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->code }}</small>
                                </div>
                            </div>
                        </td>

                        <td>{{ $product->category->name }}</td>

                        <td>Rp {{ number_format($product->purchase_price,0,',','.') }}</td>

                        <td class="fw-bold text-primary">
                            Rp {{ number_format($product->selling_price,0,',','.') }}
                        </td>

                        <td>{{ $product->stock }}</td>

                        <td>
                            @if($product->stock <= $product->minimum_stock)
                                <span class="badge bg-danger-subtle text-danger">Stok Menipis</span>
                            @else
                                <span class="badge bg-success-subtle text-success">Tersedia</span>
                            @endif
                        </td>

                        <td class="text-nowrap">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('products.destroy', $product) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Produk tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $products->links() }}
</div>

@endsection