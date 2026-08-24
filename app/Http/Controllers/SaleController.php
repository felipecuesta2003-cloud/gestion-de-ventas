<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::with('product');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sales = $query->latest()->get();

        $totalSales = $sales->sum('total');
        $totalUnits = $sales->sum('quantity');
        $salesCount = $sales->count();

        $products = Product::orderBy('name')->get();

        $productReportQuery = DB::table('sales as s')
            ->join('products as p', 's.product_id', '=', 'p.id')
            ->select(
                'p.id',
                'p.name as product',
                DB::raw('SUM(s.quantity) as total_quantity'),
                DB::raw('SUM(s.total) as total_sales')
            );

        if ($request->filled('product_id')) {
            $productReportQuery->where('s.product_id', $request->product_id);
        }

        if ($request->filled('date_from')) {
            $productReportQuery->whereDate('s.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $productReportQuery->whereDate('s.created_at', '<=', $request->date_to);
        }

        $productReport = $productReportQuery
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('total_sales')
            ->get();

        return view('sales.index', compact(
            'sales',
            'totalSales',
            'totalUnits',
            'salesCount',
            'products',
            'productReport'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($validated['product_id']);

    $unitPrice = $product->price;
    $total = $unitPrice * $validated['quantity'];

    Sale::create([
        'product_id' => $product->id,
        'quantity' => $validated['quantity'],
        'unit_price' => $unitPrice,
        'total' => $total,
    ]);

    return redirect()
        ->route('sales.index')
        ->with('success', 'Venta registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $sale = Sale::findOrFail($id);
    $products = Product::orderBy('name')->get();

    return view('sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $sale = Sale::findOrFail($id);
    $product = Product::findOrFail($validated['product_id']);

    $unitPrice = $product->price;
    $total = $unitPrice * $validated['quantity'];

    $sale->update([
        'product_id' => $product->id,
        'quantity' => $validated['quantity'],
        'unit_price' => $unitPrice,
        'total' => $total,
    ]);

    return redirect()
        ->route('sales.index')
        ->with('success', 'Venta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $sale = Sale::findOrFail($id);

    $sale->delete();

    return redirect()
        ->route('sales.index')
        ->with('success', 'Venta eliminada correctamente.');
    }
}