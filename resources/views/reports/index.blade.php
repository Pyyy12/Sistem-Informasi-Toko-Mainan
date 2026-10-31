@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')

<div class="mb-4">
    <h3 class="page-heading">Laporan Penjualan</h3>
    <p class="page-subtitle">Pantau performa penjualan toko mainan Anda.</p>
</div>

<div class="custom-card mb-4">

    <form method="GET" class="row g-3 align-items-end">

        <div class="col-md-4">
            <label class="form-label fw-bold">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-control"
                   value="{{ $start }}">
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">Tanggal Akhir</label>
            <input type="date" name="end_date" class="form-control"
                   value="{{ $end }}">
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-primary flex-fill">
                <i class="fas fa-filter me-2"></i> Filter
            </button>

            <a href="{{ route('reports.index') }}" class="btn btn-light">
                Reset
            </a>
        </div>

    </form>

</div>

<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="custom-card">
            <p class="text-muted fw-bold mb-2">Total Pendapatan</p>
            <h3 class="fw-bold text-primary">
                Rp {{ number_format($totalRevenue,0,',','.') }}
            </h3>
            <small class="text-muted">Omzet periode terpilih</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="custom-card">
            <p class="text-muted fw-bold mb-2">Total Transaksi</p>
            <h3 class="fw-bold text-success">
                {{ number_format($totalTransactions) }}
            </h3>
            <small class="text-muted">Transaksi berhasil</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="custom-card">
            <p class="text-muted fw-bold mb-2">Barang Terjual</p>
            <h3 class="fw-bold text-warning">
                {{ number_format($totalItems) }}
            </h3>
            <small class="text-muted">Total unit terjual</small>
        </div>
    </div>

</div>

<div class="row g-3">

    <div class="col-lg-8">
        <div class="custom-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Riwayat Penjualan</h5>

                <button onclick="window.print()" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-print me-1"></i> Cetak
                </button>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>INVOICE</th>
                            <th>PELANGGAN</th>
                            <th>TANGGAL</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td class="fw-bold">{{ $sale->invoice_number }}</td>
                                <td>{{ $sale->customer->name ?? 'Umum' }}</td>
                                <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                <td class="fw-bold text-primary">
                                    Rp {{ number_format($sale->grand_total,0,',','.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    Tidak ada transaksi pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $sales->links() }}
        </div>
    </div>

    <div class="col-lg-4">
        <div class="custom-card">
            <h5 class="fw-bold mb-3">Produk Terlaris</h5>

            @forelse($bestSelling as $item)
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div>
                        <div class="fw-bold">
                            {{ $item->product->name ?? 'Produk tidak tersedia' }}
                        </div>
                        <small class="text-muted">Jumlah penjualan</small>
                    </div>

                    <span class="badge bg-primary-subtle text-primary">
                        {{ $item->total_sold }} Unit
                    </span>
                </div>
            @empty
                <p class="text-muted">Belum ada produk terjual.</p>
            @endforelse

        </div>
    </div>

</div>

@endsection