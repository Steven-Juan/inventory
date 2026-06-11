@extends('layouts.app')

@section('content')
    <h1>Pencatatan Inventory</h1>
    <p>Kelola master barang dan catat stok masuk atau keluar.</p>

    <div class="grid two">
        <section class="panel">
            <h2>Daftar Barang</h2>
            <table>
                <thead>
                <tr>
                    <th>SKU</th>
                    <th>Barang</th>
                    <th>Lokasi</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->sku }}</td>
                        <td><strong>{{ $item->name }}</strong><br><span>{{ $item->category ?: '-' }}</span></td>
                        <td>{{ $item->location ?: '-' }}</td>
                        <td>{{ $item->stock }} {{ $item->unit }}</td>
                        <td><span class="badge {{ $item->isLowStock() ? 'low' : 'ok' }}">{{ $item->isLowStock() ? 'Minimum' : 'Aman' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada barang.</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $items->links() }}</div>
        </section>

        <section class="panel">
            <h2>Tambah Barang</h2>
            <form method="post" action="{{ route('inventory.items.store') }}">
                @csrf
                <label>SKU <input name="sku" value="{{ old('sku') }}" required></label>
                <label>Nama Barang <input name="name" value="{{ old('name') }}" required></label>
                <label>Kategori <input name="category" value="{{ old('category') }}"></label>
                <label>Satuan <input name="unit" value="{{ old('unit', 'pcs') }}" required></label>
                <label>Lokasi <input name="location" value="{{ old('location') }}"></label>
                <label>Stok Awal <input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" required></label>
                <label>Minimum Stok <input type="number" min="0" name="minimum_stock" value="{{ old('minimum_stock', 0) }}" required></label>
                <label>Catatan <textarea name="notes">{{ old('notes') }}</textarea></label>
                <button type="submit">Simpan Barang</button>
            </form>
        </section>
    </div>

    <div class="grid two" style="margin-top:18px">
        <section class="panel">
            <h2>Catat Mutasi</h2>
            <form method="post" action="{{ route('inventory.movements.store') }}">
                @csrf
                <label>Barang
                    <select name="item_id" required>
                        <option value="">Pilih barang</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->sku }} - {{ $item->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Tipe
                    <select name="type" required>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                </label>
                <label>Jumlah <input type="number" min="1" name="quantity" required></label>
                <label>Referensi <input name="reference" placeholder="PO, invoice, atau nomor dokumen"></label>
                <label>Dicatat Oleh <input name="created_by"></label>
                <label>Keterangan <textarea name="description"></textarea></label>
                <button class="green" type="submit">Simpan Mutasi</button>
            </form>
        </section>

        <section class="panel">
            <h2>Mutasi Terakhir</h2>
            <table>
                <thead><tr><th>Waktu</th><th>Barang</th><th>Tipe</th><th>Jumlah</th></tr></thead>
                <tbody>
                @forelse ($movements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('d/m H:i') }}</td>
                        <td>{{ $movement->item->name }}</td>
                        <td>{{ ucfirst($movement->type) }}</td>
                        <td>{{ $movement->quantity }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada mutasi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </section>
    </div>
@endsection

