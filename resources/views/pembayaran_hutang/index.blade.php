@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Pembayaran Hutang</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Nomor Pembelian</th>
                                        <th>Supplier</th>
                                        <th>Total</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->nomor_nota }}</td>
                                            <td>{{ $data->supplier->nama_supplier }}</td>
                                            <td>{{ number_format($data->total) }}</td>
                                            <td>{{ number_format($data->total_pembayaran_hutang) }}</td>
                                            <td>
                                                @if(!$data->status_lunas)
                                                    Belum Lunas
                                                @elseif($data->status_lunas)
                                                    Lunas
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$data->status_lunas)
                                                    <a href="{{ route('pembayaran_hutang.edit', $data->id) }}" class="btn btn-primary">Bayar</a>
                                                @endif
                                            </td>

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
