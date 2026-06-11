<table>
    <thead>
    <tr>
        <th>SKU</th>
        <th>Barang</th>
        <th>Kategori</th>
        <th>Lokasi</th>
        <th>Stok</th>
        <th>Minimum</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($items as $item)
        <tr>
            <td>{{ $item->sku }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->category ?: '-' }}</td>
            <td>{{ $item->location ?: '-' }}</td>
            <td>{{ $item->stock }} {{ $item->unit }}</td>
            <td>{{ $item->minimum_stock }} {{ $item->unit }}</td>
            <td><span class="badge {{ $item->isLowStock() ? 'low' : 'ok' }}">{{ $item->isLowStock() ? 'Minimum' : 'Aman' }}</span></td>
        </tr>
    @empty
        <tr><td colspan="7">Belum ada data.</td></tr>
    @endforelse
    </tbody>
</table>

