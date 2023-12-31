@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Penjualan</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">Tambah Penjualan</a>
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Jumlah Barang</th>
                                        <th>Total Harga</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $data->tanggal_penjualan }}</td>
                                            @if($data->pelanggan)
                                                <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                            @else
                                                <td>Umum</td>
                                            @endif
                                            <td>{{ $data->jumlah_barang }}</td>
                                            <td>Rp. {{ number_format($data->total) }}</td>
                                            <td>
                                                <a href="{{ route('penjualan.show', [$id = $data->id]) }}" class="btn btn-primary">Detail</a>
                                                <a href="{{ route('penjualan.edit', [$id = $data->id]) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('penjualan.destroy', $data->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" id="hapus-button">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    @include("layouts.includes.pagination")
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
    </div>
@endsection
