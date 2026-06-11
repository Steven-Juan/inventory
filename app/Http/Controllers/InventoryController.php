<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyLowStock;
use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        return view('inventory.index', [
            'items' => Item::query()->orderBy('name')->paginate(10),
            'movements' => StockMovement::query()->with('item')->latest()->limit(12)->get(),
        ]);
    }

    public function storeItem(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sku' => ['required', 'string', 'max:60', 'unique:items,sku'],
            'name' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:120'],
            'unit' => ['required', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:120'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Item::create($data);

        return back()->with('status', 'Barang berhasil ditambahkan.');
    }

    public function storeMovement(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'type' => ['required', 'in:masuk,keluar'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'created_by' => ['nullable', 'string', 'max:120'],
        ]);

        DB::transaction(function () use ($data): void {
            $item = Item::query()->lockForUpdate()->findOrFail($data['item_id']);
            $delta = $data['type'] === 'masuk' ? $data['quantity'] : -$data['quantity'];

            if ($item->stock + $delta < 0) {
                abort(422, 'Stok tidak cukup untuk mutasi keluar.');
            }

            $item->increment('stock', $delta);
            StockMovement::create($data);

            $item->refresh();
            if ($item->isLowStock()) {
                NotifyLowStock::dispatch($item->id)->afterCommit();
            }
        });

        return back()->with('status', 'Mutasi stok berhasil dicatat.');
    }
}

