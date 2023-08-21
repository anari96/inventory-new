@extends('layouts.app')

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
                            <div class="col">
                                <div class="button-demo">
                                    <a href="{{ Route('service.list') }}?status=pending" class="btn @if($status == 'pending') btn-primary @else btn-outline-primary @endif waves-effect">ANTRI</a>
                                    <a href="{{ Route('service.list') }}?status=dikerjakan" class="btn @if($status == 'dikerjakan') btn-primary @else btn-outline-primary @endif waves-effect">PRIMARY</a>
                                    <a href="{{ Route('service.list') }}?status=selesai" class="btn @if($status == 'selesai') btn-primary @else btn-outline-primary @endif waves-effect">SELESAI</a>
                                    <a href="{{ Route('service.list') }}?status=diambil" class="btn @if($status == 'diambil') btn-primary @else btn-outline-primary @endif waves-effect">DIAMBIL</a>
                                    <a href="{{ Route('service.list') }}?status=batal" class="btn @if($status == 'batal') btn-primary @else btn-outline-primary @endif waves-effect">BATAL</a>
                                    <a href="{{ Route('service.list') }}?status=refund" class="btn @if($status == 'refund') btn-primary @else btn-outline-primary @endif waves-effect">REFUND</a>
                                </div>
                            </div>
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
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
                                            <td>{{ number_format($data->biaya) }}</td>
                                            <td>{{ $data->teknisi->nama_teknisi }}</td>
                                            <td>
                                               @if($status != "diambil" && $status != "refund")
                                                    <form action="{{ route('service.proses', $data->id) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        @if($status == "pending")
                                                        <input type="hidden" name="status" value="dikerjakan">
                                                        @elseif($status == "dikerjakan")
                                                        <input type="hidden" name="status" value="selesai">
                                                        @elseif($status == "selesai")
                                                        <input type="hidden" name="status" value="diambil">
                                                        @endif
                                                        <button type="submit" class="btn btn-success">Proses</button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('service.edit', [$id = $data->id]) }}" class="btn btn-primary">Edit</a>
                                                @if($status != "batal" && $status != "selesai" && $status != "refund" && $status != "diambil")
                                                    <form action="{{ route('service.proses', $data->id) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="batal">
                                                        <button type="submit" class="btn btn-danger">Batal</button>
                                                    </form>
                                                @elseif($status == "batal")
                                                    <form action="{{ route('service.proses', $data->id) }}" method="POST" style="display:inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="refund">
                                                        <button type="submit" class="btn btn-danger">Refund</button>
                                                    </form>
                                                @endif
                                            </td>
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
