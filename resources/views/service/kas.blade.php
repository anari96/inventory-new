@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
        </div>



        <div class="row-clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row-clearfix">
                            <div class="col">
                                <h2>Kas</h2>
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
                                        <div class="text" style="margin-bottom: 10px">Saldo</div>
                                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ number_format($jumlahTotal) }}</div>
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
                                <a href="{{ Route('service.kas') }}?status=pending" class="btn @if($status == 'pending') btn-primary @else btn-outline-primary @endif waves-effect">Belum Lunas</a>
                                <a href="{{ Route('service.kas') }}?status=selesai" class="btn @if($status == 'selesai') btn-primary @else btn-outline-primary @endif waves-effect">Lunas</a>
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
                                        <th>Sparepart</th>
                                        <th>Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($datas as $data)
                                            <tr>
                                                <td>{{ $data->tanggal }}</td>
                                                <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                                                <td>
                                                    @foreach($data->detail as $detail)
                                                        {{$detail->sparepart->nama_item}} <br>
                                                    @endforeach
                                                </td>
                                                <td>{{ number_format($data->total_sparepart) }}</td>
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
