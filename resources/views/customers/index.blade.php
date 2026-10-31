@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="page-heading">Data Pelanggan</h3>
        <p class="page-subtitle">Kelola informasi pelanggan ToyStore.</p>
    </div>

    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Tambah Pelanggan
    </a>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA PELANGGAN</th>
                    <th>TELEPON</th>
                    <th>EMAIL</th>
                    <th>ALAMAT</th>
                    <th>AKSI</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customers->firstItem() + $loop->index }}</td>
                        <td class="fw-bold">{{ $customer->name }}</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>{{ $customer->email ?? '-' }}</td>
                        <td>{{ $customer->address ?? '-' }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('customers.edit', $customer) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('customers.destroy', $customer) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus pelanggan ini?')">
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
                        <td colspan="6" class="text-center py-4">
                            Belum ada pelanggan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $customers->links() }}
</div>

@endsection