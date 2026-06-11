@extends('layouts.app')

@section('content')
    <h1>Cetak Laporan</h1>
    <p>Ringkasan stok dan laporan siap print atau export CSV.</p>

    <div class="grid four">
        <div class="metric">Total Barang <strong>{{ $summary['total_items'] }}</strong></div>
        <div class="metric">Total Stok <strong>{{ $summary['total_stock'] }}</strong></div>
        <div class="metric">Stok Minimum <strong>{{ $summary['low_stock'] }}</strong></div>
        <div class="metric">Mutasi Hari Ini <strong>{{ $summary['movements_today'] }}</strong></div>
    </div>

    <section class="panel" style="margin-top:18px">
        <form class="no-print" method="get" action="{{ route('reports.index') }}" style="grid-template-columns:repeat(3, minmax(0, 1fr)); align-items:end">
            <label>Cari <input name="q" value="{{ $filters['q'] ?? '' }}" placeholder="SKU atau nama"></label>
            <label>Kategori <input name="category" value="{{ $filters['category'] ?? '' }}"></label>
            <div class="actions">
                <button type="submit">Filter</button>
                <a class="button secondary" href="{{ route('reports.print', request()->query()) }}">Print</a>
                <a class="button green" href="{{ route('reports.csv', request()->query()) }}">CSV</a>
            </div>
        </form>

        <h2 style="margin-top:18px">Stok Barang</h2>
        @include('reports.partials.stock-table')
        <div class="pagination">{{ $items->links() }}</div>
    </section>

    <section class="panel" style="margin-top:18px">
        <h2>Total Per Kategori</h2>
        <table>
            <thead><tr><th>Kategori</th><th>Jumlah Barang</th><th>Total Stok</th></tr></thead>
            <tbody>
            @forelse ($categoryTotals as $category)
                <tr>
                    <td>{{ $category->category ?: 'Tanpa kategori' }}</td>
                    <td>{{ $category->total_items }}</td>
                    <td>{{ $category->total_stock }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Belum ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
@endsection

