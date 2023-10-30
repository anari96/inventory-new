@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Laporan Pembelian</h2>
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
                                        <th>Tanggal</th>
                                        <th>Nama Supplier</th>
                                        <th>Jumlah Barang</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $data->tanggal_pembelian }}</td>
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
                                    <tr>
                                        <td colspan="5">
                                            @if($datas->currentPage() != 1)
                                                <a href="{{ $datas->previousPageUrl() }}" @if($datas->currentPage() == 1) style="display:none;" @endif > Previous </a>
                                                <a href="{{ $datas->url(1) }}">1</a>
                                            @endif
                                            @for($i = max($datas->currentPage() - 5,2); $i < $datas->currentPage(); $i++ )
                                                <a href="{{ $datas->url($i) }}">{{ $i }}</a>
                                            @endfor
                                            <a href="{{ $datas->url($datas->currentPage()) }}" style="font-weight: bold"> {{$datas->currentPage()}} </a>
                                            @if($datas->currentPage() != $datas->lastPage() && $datas->currentPage() !=  $datas->lastPage() - 1)
                                                @for($i = $datas->currentPage() + 1; $i < $datas->currentPage() + 5; $i++ )
                                                    @if($i < $datas->lastPage() )
                                                        <a href="{{ $datas->url($i) }}">{{ $i }}</a>
                                                    @endif
                                                @endfor
                                            @endif
                                            @if($datas->currentPage() != $datas->lastPage())
                                                <a href="{{$datas->url($datas->lastPage())}}">{{$datas->lastPage()}}</a>
                                                <a href="{{ $datas->nextPageUrl() }}"  > Next </a>
                                            @endif
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
