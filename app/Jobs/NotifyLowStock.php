<?php

namespace App\Jobs;

use App\Models\CommunicationMessage;
use App\Models\Item;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyLowStock implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $itemId)
    {
    }

    public function handle(): void
    {
        $item = Item::find($this->itemId);

        if (! $item || ! $item->isLowStock()) {
            return;
        }

        CommunicationMessage::create([
            'type' => 'notifikasi',
            'title' => 'Stok minimum tercapai',
            'body' => "Barang {$item->name} ({$item->sku}) tersisa {$item->stock} {$item->unit}. Minimum stok: {$item->minimum_stock}.",
            'sender' => 'Sistem Inventory',
            'recipient' => 'Tim Gudang',
        ]);
    }
}

