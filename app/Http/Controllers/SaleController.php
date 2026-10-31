<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')
            ->latest('sale_date')
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->get();

        $customers = Customer::orderBy('name')->get();

        return view('sales.create', compact(
            'products',
            'customers'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris',
            'notes' => 'nullable|string',
        ]);

        $sale = DB::transaction(function () use ($validated) {
            $total = 0;
            $items = [];

            foreach ($validated['products'] as $item) {
                $product = Product::whereKey($item['id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'products' => "Stok {$product->name} tidak mencukupi.",
                    ]);
                }

                $subtotal = (float) $product->selling_price * $quantity;

                $total += $subtotal;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $product->selling_price,
                    'subtotal' => $subtotal,
                ];
            }

            $discount = (float) ($validated['discount'] ?? 0);

            if ($discount > $total) {
                throw ValidationException::withMessages([
                    'discount' => 'Diskon tidak boleh melebihi total belanja.',
                ]);
            }

            $grandTotal = $total - $discount;
            $paid = (float) $validated['paid_amount'];

            if ($paid < $grandTotal) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Pembayaran masih kurang.',
                ]);
            }

            $sale = Sale::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis')
                    . '-' . Str::upper(Str::random(4)),
                'customer_id' => $validated['customer_id'] ?? null,
                'user_id' => auth()->id(),
                'sale_date' => now(),
                'total_amount' => $total,
                'discount' => $discount,
                'grand_total' => $grandTotal,
                'paid_amount' => $paid,
                'change_amount' => $paid - $grandTotal,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                $sale->details()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['product']->decrement(
                    'stock',
                    $item['quantity']
                );
            }

            return $sale;
        });

        return redirect()->route('sales.show', $sale)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['customer', 'details.product', 'user']);

        return view('sales.show', compact('sale'));
    }

    public function cancel(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            $sale = Sale::whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($sale->status !== 'completed') {
                throw ValidationException::withMessages([
                    'sale' => 'Transaksi sudah dibatalkan.',
                ]);
            }

            foreach ($sale->details as $detail) {
                Product::whereKey($detail->product_id)
                    ->lockForUpdate()
                    ->increment('stock', $detail->quantity);
            }

            $sale->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Transaksi dibatalkan dan stok dikembalikan.');
    }
}