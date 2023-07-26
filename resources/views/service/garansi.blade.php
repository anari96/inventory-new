@extends('layouts.app')

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
                                    <div class="row"><img src="https://camo.githubusercontent.com/5c0e557ce429b13dfd71ef0c05124eda691129db9c7ca21787790a488ab5030d/68747470733a2f2f656e64726f69642e6e6c2f71722d636f64652f64656661756c742f4c6966652532306973253230746f6f25323073686f7274253230746f253230626525323067656e65726174696e672532305152253230636f646573" style="width: 120px;height:120px" alt="qr"></div>
                                    <div class="row">Aktif</div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                        <div class="row row-clearfix">
                            <div class="text-center">
                                {{ $datas->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
    </div>
@endsection
