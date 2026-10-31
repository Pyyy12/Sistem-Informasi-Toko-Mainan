@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="page-heading">Transaksi Penjualan</h3>
        <p class="page-subtitle">Kelola seluruh transaksi penjualan mainan.</p>
    </div>

    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Transaksi Baru
    </a>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>INVOICE</th>
                    <th>PELANGGAN</th>
                    <th>TANGGAL</th>
                    <th>PEMBAYARAN</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sales->firstItem() + $loop->index }}</td>

                        <td class="fw-bold">{{ $sale->invoice_number }}</td>

                        <td>{{ $sale->customer->name ?? 'Pelanggan Umum' }}</td>

                        <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>

                        <td>
                            <span class="badge bg-info-subtle text-info">
                                {{ strtoupper($sale->payment_method) }}
                            </span>
                        </td>

                        <td class="fw-bold text-primary">
                            Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
                        </td>

                        <td>
                            @if($sale->status == 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>

                        <td class="text-nowrap">
                            <a href="{{ route('sales.show', $sale) }}"
                               class="btn btn-sm btn-info text-white">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if($sale->status == 'completed')
                                <form action="{{ route('sales.cancel', $sale) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Batalkan transaksi dan kembalikan stok?')">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            Belum ada transaksi penjualan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $sales->links() }}
</div>

@endsection