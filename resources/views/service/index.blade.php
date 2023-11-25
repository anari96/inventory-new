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
                                                <option value="pending" @if($request->status == "pending") selected @endif
                                                )>Pending</option>
                                                <option value="dikerjakan" @if($request->status == "dikerjakan") selected @endif>Dikerjakan</option>
                                                <option value="selesai" @if($request->status == "selesai") selected @endif>Selesai</option>
                                                <option value="batal" @if($request->status == "batal") selected @endif>Batal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">assignment</i>
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control" name="status_pembayaran">
                                                <option value="">Pilih Status Pembayaran</option>
                                                <option value="belum_ditanggapi" @if($request->status_pembayaran == "belum_ditanggapi") selected @endif>Belum Ditanggapi</option>
                                                <option value="belum_lunas" @if($request->status_pembayaran == "belum_lunas") selected @endif>Belum Lunas</option>
                                                <option value="lunas" @if($request->status_pembayaran == "lunas") selected @endif>Sudah Lunas</option>
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
                                            <input class="form-control" placeholder="No. Service/Nama Pelanggan" name="nama_pelanggan" value="{{ $request->nama_pelanggan }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <button class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table" style="">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'no_service','sorting_order' => $sorting_order])}}">No. Service</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'tanggal','sorting_order' => $sorting_order])}}">Tanggal</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'nama_pelanggan','sorting_order' => $sorting_order])}}">Nama Pelanggan/No. Telepon</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'status','sorting_order' =>$sorting_order])}}">Status</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'merk','sorting_order' =>$sorting_order])}}">Merek</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'deskripsi','sorting_order' => $sorting_order])}}">Kerusakan</a></th>
                                        <th><a href="{{request()->fullUrlWithQuery(['order' => 'nama_teknisi','sorting_order' =>$sorting_order])}}">Nama Teknisi</a></th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->no_service }}</td>
                                            <td>{{ $data->tanggal }}</td>
                                            <td>{{ $data->pelanggan->nama_pelanggan }} ({{ $data->pelanggan->telp_pelanggan }})</td>
                                            <td>
                                                @switch($data->status)
                                                    @case("pending")
                                                        <span class="label label-danger">{{ $data->status }}</span>
                                                        @break
                                                    @case("dikerjakan")
                                                        <span class="label label-primary">{{ $data->status }}</span>
                                                        @break
                                                    @case("selesai")
                                                        <span class="label label-success">{{ $data->status }}</span>
                                                        @break
                                                    @case("batal")
                                                        <span class="label label-danger">{{ $data->status }}</span>
                                                        @break
                                                    @default
                                                        <span class="label label-success">{{ $data->status }}</span>
                                                @endswitch
                                                @switch($data->status_pembayaran)
                                                    @case('belum_ditanggapi')
                                                        <span class="label label-danger">{{ $data->status_pembayaran_label }}</span>
                                                        @break
                                                    @case('belum_lunas')
                                                        <span class="label label-warning">{{ $data->status_pembayaran_label }}</span>
                                                        @break
                                                    @case('lunas')
                                                        <span class="label label-success">{{ $data->status_pembayaran_label }}</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $data->merk }}</td>
                                            <td>{{ $data->deskripsi }}</td>
                                            <td>{{ $data->teknisi->nama_teknisi }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if($data->status != "pending")
                                                            <li><a href="{{ route('service.proses', $data->id) }}?status=pending">Pending</a></li>
                                                        @endif
                                                        @if($data->status != "dikerjakan")
                                                            <li><a href="{{ route('service.proses', $data->id) }}?status=dikerjakan">Dikerjakan</a></li>
                                                        @endif
                                                        @if($data->status != "selesai")
                                                            <li><a href="{{ route('service.proses', $data->id) }}?status=selesai">Selesai</a></li>
                                                        @endif
                                                        @if($data->status != "batal")
                                                            <li><a href="{{ route('service.proses', $data->id) }}?status=batal">Batal</a></li>
                                                        @endif
                                                            <li role="separator" class="divider"></li>
                                                            <li><a href="{{ route('pembayaran_service.edit', $data->id) }}">Bayar</a></li>
                                                            <li><a href="{{ route('pesan.edit', $data->id) }}">Kirim Pesan</a></li>
<!--                                                             <li><a href="javascript:void(0);">Batal</a></li> -->
                                                    </ul>
                                                </div>
                                                <a href="{{ route('service.edit', [$id = $data->id]) }}" class="btn btn-primary">Edit</a>
                                                @if($data->status == "selesai" && $data->status_pembayaran == "lunas")
                                                    <a href="{{ route('service.garansi.create', [$id = $data->id]) }}" class="btn btn-primary">Garansi</a>
                                                @endif
                                                <form action="{{ route('service.destroy', $data->id) }}" method="POST" style="display:inline">
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
