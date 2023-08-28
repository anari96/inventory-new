@extends('layouts.app')

@push("scripts")
<script>
    let qrCodeClass = document.querySelectorAll(".qrcode");

    qrCodeClass.forEach((e) => {
        let textValue = e.children[0].value;
        new QRCode(e, {
            text: textValue,
            width : 100,
            height : 100
        });
    });

</script>
@endpush

@push('styles')
<style>
    .qr-card{
        border: 1px solid grey;
        padding:12px 10px 10px 10px;
        color:black;
        width: 25%;
        margin:5px 5px 5px 5px;
    }

</style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="block-header">
        </div>

        <div class="row row-clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row-clearfix">
                            <div class="col">
                                <h2>Garansi</h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row row-clearfix">
                        @foreach($datas as $data)
                            <a class="col-md-4 qr-card">
                                <div class="col-md-6">
                                    <div class="row" style="font-weight:bold;">Konsumen :</div>
                                    <div class="row" >{{ $data->pelanggan->nama_pelanggan }}</div>
                                    <div class="row" style="font-weight:bold;">Barang :</div>
                                    <div class="row">{{ $data->merk }}</div>
                                    <div class="row" style="font-weight:bold;">Kerusakan :</div>
                                    <div class="row">{{ $data->kerusakan }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">Status Garansi :</div>
                                    <div class="row">
                                            <div class="qrcode">
                                                <input type="hidden" value="{{ $data->id }}">
                                            </div>
                                    </div>
                                    <div class="row">Aktif</div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                        <div class="row row-clearfix">
                            <div class="text-center">
                                @if($datas->currentPage() != 1)
                                    <a href="{{ $datas->previousPageUrl() }}" @if($datas->currentPage() == 1) style="display:none;" @endif > Previous </a>
                                    <a href="{{ $datas->url(1) }}">1</a>
<!--                                     <p href="">..</p> -->
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
<!--                                     <p href="">..</p> -->
                                    <a href="{{$datas->url($datas->lastPage())}}">{{$datas->lastPage()}}</a>
                                    <a href="{{ $datas->nextPageUrl() }}"  > Next </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
    </div>
@endsection
