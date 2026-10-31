<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $totalCustomers = Customer::count();

        $totalTransactions = Sale::where('status', 'completed')->count();

        $totalRevenue = Sale::where('status', 'completed')
            ->sum('grand_total');

        $todayRevenue = Sale::where('status', 'completed')
            ->whereDate('sale_date', today())
            ->sum('grand_total');

        $lowStock = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        $recentSales = Sale::with('customer')
            ->latest('sale_date')
            ->take(8)
            ->get();

        $monthlySales = Sale::selectRaw(
            'MONTH(sale_date) as month, SUM(grand_total) as total'
        )
            ->where('status', 'completed')
            ->whereYear('sale_date', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartLabels = [];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $chartData[] = (float) ($monthlySales[$i] ?? 0);
        }

        $bestSelling = SaleDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold')
        )
            ->whereHas('sale', function ($query) {
                $query->where('status', 'completed');
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalCustomers',
            'totalTransactions',
            'totalRevenue',
            'todayRevenue',
            'lowStock',
            'recentSales',
            'chartLabels',
            'chartData',
            'bestSelling'
        ));
    }
}