@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h3 class="page-heading">Dashboard Overview 👋</h3>
        <p class="page-subtitle">Selamat datang di sistem manajemen ToyStore.</p>
    </div>

    <div class="text-muted small">
        <i class="far fa-calendar-alt me-1"></i>
        {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="custom-card stat-card">
            <div>
                <p>Total Produk</p>
                <h3>{{ number_format($totalProducts) }}</h3>
                <small class="text-muted">Produk terdaftar</small>
            </div>
            <div class="stat-icon" style="background:#eeeaff;color:#6558e8;">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="custom-card stat-card">
            <div>
                <p>Total Kategori</p>
                <h3>{{ number_format($totalCategories) }}</h3>
                <small class="text-muted">Kategori mainan</small>
            </div>
            <div class="stat-icon" style="background:#e1f8ef;color:#20a875;">
                <i class="fas fa-layer-group"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="custom-card stat-card">
            <div>
                <p>Total Pelanggan</p>
                <h3>{{ number_format($totalCustomers) }}</h3>
                <small class="text-muted">Pelanggan terdaftar</small>
            </div>
            <div class="stat-icon" style="background:#fff0e5;color:#f39b48;">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="custom-card stat-card">
            <div>
                <p>Total Transaksi</p>
                <h3>{{ number_format($totalTransactions) }}</h3>
                <small class="text-muted">Transaksi berhasil</small>
            </div>
            <div class="stat-icon" style="background:#ffe9ef;color:#ec6387;">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>

</div>

<div class="row g-3 mb-4">

    <div class="col-lg-8">
        <div class="custom-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Grafik Penjualan</h5>
                    <small class="text-muted">Total omzet per bulan tahun {{ date('Y') }}</small>
                </div>
                <span class="badge bg-primary-subtle text-primary">Tahunan</span>
            </div>

            <canvas id="salesChart" height="110"></canvas>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="custom-card mb-3">
            <p class="text-muted fw-bold mb-2">Total Pendapatan</p>
            <h3 class="fw-bold text-primary">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h3>
            <small class="text-muted">Seluruh transaksi berhasil</small>
        </div>

        <div class="custom-card mb-3">
            <p class="text-muted fw-bold mb-2">Pendapatan Hari Ini</p>
            <h3 class="fw-bold text-success">
                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
            </h3>
            <small class="text-muted">Omzet penjualan hari ini</small>
        </div>

        <div class="custom-card">
            <p class="text-muted fw-bold mb-2">Stok Menipis</p>
            <h3 class="fw-bold text-danger">{{ $lowStock }}</h3>
            <a href="{{ route('products.index') }}" class="small text-decoration-none">
                Periksa stok produk <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

</div>

<div class="row g-3">

    <div class="col-lg-8">
        <div class="custom-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Transaksi Terbaru</h5>
                <a href="{{ route('sales.index') }}" class="small text-decoration-none">Lihat semua</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>INVOICE</th>
                            <th>PELANGGAN</th>
                            <th>TANGGAL</th>
                            <th>TOTAL</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                            <tr>
                                <td class="fw-bold">
                                    {{ $sale->invoice_number }}
                                </td>
                                <td>{{ $sale->customer->name ?? 'Umum' }}</td>
                                <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge {{ $sale->status == 'completed' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="custom-card">
            <h5 class="fw-bold mb-3">Produk Terlaris</h5>

            @forelse($bestSelling as $item)
                <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                    <div>
                        <div class="fw-bold">
                            {{ $item->product->name ?? 'Produk dihapus' }}
                        </div>
                        <small class="text-muted">Terjual {{ $item->total_sold }} unit</small>
                    </div>
                    <i class="fas fa-trophy text-warning"></i>
                </div>
            @empty
                <p class="text-muted">Belum ada data penjualan.</p>
            @endforelse
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($chartData),
                borderColor: '#6558e8',
                backgroundColor: 'rgba(101,88,232,.10)',
                fill: true,
                tension: .4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#6558e8'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
                    },
                    grid: {
                        color: '#f0f0f5'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush