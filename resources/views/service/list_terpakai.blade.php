@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Service</h2>
        </div>



        <div class="row-clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row-clearfix">
                            <div class="col">
                                <h2>Sparepart Yang Terpakai</h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box bg-brown hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">Sparepart Toko Bulan Ini</div>
                                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ number_format($totalSparepartToko) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-green hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">Sparepart Luar Bulan Ini</div>
                                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ number_format($totalSparepartLuar) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-green hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">Service Laba</div>
                                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ number_format( $totalSparepartToko + $totalSparepartLuar) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="col">
                            <div class="button-demo">
                                <button type="button" class="btn btn-primary waves-effect">Sparepart</button>
                                <button type="button" class="btn btn-outline-primary waves-effect">Tanpa Sparepart</button>
                                <button type="button" class="btn btn-outline-primary waves-effect">Sparepart Luar</button>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>No. Hp</th>
                                        <th>Merek</th>
                                        <th>Tipe</th>
                                        <th>IMEI 1</th>
                                        <th>IMEI 2</th>
                                        <th>Kerusakan</th>
                                        <th>Deskripsi</th>
                                        <th>Kelengkapan</th>
                                        <th>Biaya</th>
                                        <th>Teknisi</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->tanggal }}</td>
                                            <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                            <td>{{ $data->pelanggan->telp_pelanggan }}</td>
                                            <td>{{ $data->merk }}</td>
                                            <td>{{ $data->tipe }}</td>
                                            <td>{{ $data->imei1 }}</td>
                                            <td>{{ $data->imei2 }}</td>
                                            <td>{{ $data->kerusakan }}</td>
                                            <td>{{ $data->deskripsi }}</td>
                                            <td>{{ $data->kelengkapan }}</td>
                                            <td>{{ number_format($data->total_sparepart) }}</td>
                                            <td>{{ $data->teknisi->nama_teknisi }}</td>
                                            <td><a href="{{ route('service.edit', [$id = $data->id]) }}" class="btn btn-primary">Edit</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <div class="text-center">
                                            </div>
                                        </td>
                                    </tr>
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
