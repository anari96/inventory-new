
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Laporan</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Laporan</h2>
                    </div>
                    <div class="body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="header row">
                                            <a href="" class="col-md-12" style="margin-bottom: 0;"><i class="material-icons col-red">description</i> <h2>Laporan Service</h2></a>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="header row">
                                            <a href="{{route('laporan.penjualan')}}" class="col-md-12" style="margin-bottom: 0;"><i class="material-icons col-red">description</i> <h2>Laporan Penjualan</h2></a>
                                    </div>

                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="card">
                                    <div class="header row">
                                            <a href="" class="col-md-12" style="margin-bottom: 0;"><i class="material-icons col-red">description</i> <h2>Laporan Pembelian</h2></a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
    </div>
@endsection
