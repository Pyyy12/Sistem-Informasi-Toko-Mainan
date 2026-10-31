@extends('layouts.app')

@section('title', 'Kategori Mainan')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="page-heading">Kategori Mainan</h3>
        <p class="page-subtitle">Kelola kategori produk mainan anak-anak.</p>
    </div>

    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Tambah Kategori
    </a>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>GAMBAR</th>
                    <th>NAMA KATEGORI</th>
                    <th>JUMLAH PRODUK</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/'.$category->image) }}" class="product-thumb">
                            @else
                                <div class="product-thumb d-grid place-items-center text-primary">
                                    <i class="fas fa-shapes"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $category->name }}</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('categories.destroy', $category) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->links() }}
</div>

@endsection