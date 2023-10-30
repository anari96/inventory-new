@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Laporan</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <p>Laporan Penjualan</p>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="header row">
                                            <div class="col-md-12" style="margin-bottom: 0;"><i class="material-icons col-red">report_problem</i> <h2>Pendapatan</h2></div>
                                    </div>
                                    <div class="body row" style="padding-top:0">
                                        <div class="col-md-12" style="margin-bottom:0px;margin-top:0">
                                            <h1>Rp. {{ number_format($pendapatan) }}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Jumlah Barang</th>
                                        <th>Total Harga</th>
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
