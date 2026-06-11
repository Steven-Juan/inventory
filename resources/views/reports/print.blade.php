@extends('layouts.app')

@section('content')
    <section class="panel">
        <h1>Laporan Stok Inventory</h1>
        <p>Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
        @include('reports.partials.stock-table')
    </section>
    <script>window.print();</script>
@endsection

