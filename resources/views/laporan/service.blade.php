@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            $('#daterange').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function(start, end, label) {

                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
                var delayInMilliseconds = 500; //1 second

                setTimeout(function() {
                    $("#filter-form").submit();
                }, delayInMilliseconds);

            });
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Service</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('service.create') }}" class="btn btn-primary">Tambah Service</a>
                    </div>
                    <div class="body">

                        <form action="" id="filter-form">
                            <div class="row">
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">

                                            <input type="text" class="form-control" name="periode" id="daterange"
                                                value="@if(isset($periode)){{ $periode[0] }} - {{ $periode[1] }} @endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">assignment</i>
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control" name="status">
                                                <option value="">Pilih Status</option>
                                                <option value="pending">Pending</option>
                                                <option value="dikerjakan">Dikerjakan</option>
                                                <option value="selesai">Selesai</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line">
                                            <input class="form-control" placeholder="Nama Pelanggan" name="nama_pelanggan">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <button class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'tanggal','sorting_order' => $sorting_order])}}">Tanggal</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'nama_pelanggan','sorting_order' => $sorting_order])}}">Nama Pelanggan/No. Telepon</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'status','sorting_order' =>$sorting_order])}}">Status</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'merk','sorting_order' =>$sorting_order])}}">Merek</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'tipe','sorting_order' =>$sorting_order])}}">Tipe</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'imei1','sorting_order' => $sorting_order])}}">IMEI 1</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'imei2','sorting_order' => $sorting_order])}}">IMEI 2</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'deskripsi','sorting_order' => $sorting_order])}}">Deskripsi</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'nama_teknisi','sorting_order' =>$sorting_order])}}">Nama Teknisi</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->tanggal }}</td>
                                            <td>{{ $data->pelanggan->nama_pelanggan }} ({{ $data->pelanggan->telp_pelanggan }})</td>
                                            <td>{{ $data->status }} - ( {{$data->status_lunas}} )</td>
                                            <td>{{ $data->merk }}</td>
                                            <td>{{ $data->tipe }}</td>
                                            <td>{{ $data->imei1 }}</td>
                                            <td>{{ $data->imei2 }}</td>
                                            <td>{{ $data->deskripsi }}</td>
                                            <td>{{ $data->teknisi->nama_teknisi }}</td>
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
