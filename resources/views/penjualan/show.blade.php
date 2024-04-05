@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($detail)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ $detail->detail_id }}</td>
            </tr>
            <tr>
                <th>User</th>
                <td>{{ $detail->penjualan->user->username }}</td>
            </tr>
            <tr>
                <th>Pembeli</th>
                <td>{{ $detail->penjualan->pembeli }}</td>
            </tr>
            <tr>
                <th>Kode Penjualan</th>
                <td>{{ $detail->penjualan->penjualan_kode }}</td>
            </tr>
            <tr>
                <th>Tanggal Penjualan</th>
                <td>{{ $detail->penjualan->penjualan_tanggal }}</td>
            </tr>
            <tr>
                <th>Kode Barang</th>
                <td>{{ $detail->barang->barang_kode }}</td>
            </tr>
            <tr>
                <th>Kategori Barang</th>
                <td>{{ $detail->barang->kategori->kategori_nama }}</td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td>{{ $detail->barang->barang_nama }}</td>
            </tr>
            <tr>
                <th>Harga Beli</th>
                <td>{{ $detail->barang->harga_beli }}</td>
            </tr>
            <tr>
                <th>Harga Jual</th>
                <td>{{ $detail->barang->harga_jual }}</td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>{{ $detail->jumlah }}</td>
            </tr>
        </table>
        @endempty
        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
