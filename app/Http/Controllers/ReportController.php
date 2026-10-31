<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end = $request->end_date ?? now()->toDateString();

        $query = Sale::where('status', 'completed')
            ->whereDate('sale_date', '>=', $start)
            ->whereDate('sale_date', '<=', $end);

        $sales = (clone $query)
            ->with('customer')
            ->latest('sale_date')
            ->paginate(10)
            ->withQueryString();

        $totalRevenue = (clone $query)->sum('grand_total');
        $totalTransactions = (clone $query)->count();

        $totalItems = SaleDetail::whereHas('sale', function ($q) use ($start, $end) {
            $q->where('status', 'completed')
                ->whereDate('sale_date', '>=', $start)
                ->whereDate('sale_date', '<=', $end);
        })->sum('quantity');

        $bestSelling = SaleDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_sold')
        )
            ->whereHas('sale', function ($q) use ($start, $end) {
                $q->where('status', 'completed')
                    ->whereBetween('sale_date', [
                        $start . ' 00:00:00',
                        $end . ' 23:59:59',
                    ]);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'sales',
            'totalRevenue',
            'totalTransactions',
            'totalItems',
            'bestSelling',
            'start',
            'end'
        ));
    }
}