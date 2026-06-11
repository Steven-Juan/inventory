<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('reports.index', $this->reportData($request));
    }

    public function print(Request $request): View
    {
        return view('reports.print', $this->reportData($request));
    }

    public function csv(Request $request): StreamedResponse
    {
        $items = $this->filteredItems($request)->get();

        return response()->streamDownload(function () use ($items): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['SKU', 'Nama', 'Kategori', 'Lokasi', 'Stok', 'Minimum', 'Satuan']);

            foreach ($items as $item) {
                fputcsv($handle, [
                    $item->sku,
                    $item->name,
                    $item->category,
                    $item->location,
                    $item->stock,
                    $item->minimum_stock,
                    $item->unit,
                ]);
            }

            fclose($handle);
        }, 'laporan-stok.csv', ['Content-Type' => 'text/csv']);
    }

    private function reportData(Request $request): array
    {
        $items = $this->filteredItems($request)->paginate(20)->withQueryString();

        return [
            'items' => $items,
            'summary' => [
                'total_items' => Item::count(),
                'total_stock' => Item::sum('stock'),
                'low_stock' => Item::whereColumn('stock', '<=', 'minimum_stock')->count(),
                'movements_today' => StockMovement::whereDate('created_at', now()->toDateString())->count(),
            ],
            'categoryTotals' => Item::query()
                ->select('category', DB::raw('sum(stock) as total_stock'), DB::raw('count(*) as total_items'))
                ->groupBy('category')
                ->orderBy('category')
                ->get(),
            'filters' => $request->only(['category', 'q']),
        ];
    }

    private function filteredItems(Request $request)
    {
        return Item::query()
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->when($request->filled('q'), function ($query) use ($request): void {
                $keyword = '%'.$request->string('q')->toString().'%';
                $query->where(function ($query) use ($keyword): void {
                    $query->where('name', 'like', $keyword)->orWhere('sku', 'like', $keyword);
                });
            })
            ->orderBy('name');
    }
}

