<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Item::firstOrCreate(
            ['sku' => 'BRG-001'],
            [
                'name' => 'Kabel LAN Cat6',
                'category' => 'Jaringan',
                'unit' => 'roll',
                'location' => 'Rak A1',
                'stock' => 12,
                'minimum_stock' => 5,
            ],
        );

        Item::firstOrCreate(
            ['sku' => 'BRG-002'],
            [
                'name' => 'Keyboard USB',
                'category' => 'Aksesoris',
                'unit' => 'pcs',
                'location' => 'Rak B2',
                'stock' => 4,
                'minimum_stock' => 10,
            ],
        );
    }
}

