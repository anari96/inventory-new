
@extends('layouts.app')

@push('scripts')
<script>

$(function () {
    new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));
});

function getChartJs(type) {
    var config = null;

    if (type === 'bar') {
        config = {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "My First dataset",
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: 'rgba(0, 188, 212, 0.8)'
                }, {
                        label: "My Second dataset",
                        data: [28, 48, 40, 19, 86, 27, 90],
                        backgroundColor: 'rgba(233, 30, 99, 0.8)'
                    }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    return config;
}

</script>
@endpush

@push('styles')
.circle {
    height: 50px;
    width: 50px;
    background-color: #555;
    border-radius: 50%;
  }
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row-clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row-clearfix">
                            <div class="col">
                                <h2>Maintainance</h2>
                                <small>Update Terbaru Untuk Perbaikan Unit</small>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="header row">
                                            <div class="col-md-12" style="margin-bottom: 0;"><i class="material-icons col-red">report_problem</i> <h2>Antrian</h2></div>
                                    </div>
                                    <div class="body row" style="padding-top:0">
                                        <div class="col-md-12" style="margin-bottom:0px;margin-top:0">
                                            <h1>{{ $service_pending }} Unit</h1>
<!--                                             <small><span class="col-green">+{{ $service_pending_harian }}</span> Hari Ini</small> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="header row">
                                        <div class="col-md-12" style="margin-bottom: 0"><i class="material-icons col-yellow">error</i> <h2>Dikerjakan</h1></div>
                                    </div>
                                    <div class="body row" style="padding-top:0" >
                                        <div class="col-md-12" style="margin-bottom: 0;margin-top:0;" >
                                            <h1>{{ $service_dikerjakan }} Unit</h1>
<!--                                             <small><span class="col-green">+{{ $service_dikerjakan_harian }}</span> Hari Ini</small> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="header row">
                                            <div class="col-md-12" style="margin-bottom: 0"><i class="material-icons col-green">check_circle</i> <h2>Sudah Diperbaiki</h2></div>
                                    </div>
                                    <div class="body row" style="padding-top: 0;">
                                        <div class="col-md-12" style="margin-bottom: 0;margin-top:0">
                                            <h1>{{ $service_selesai }} Unit</h1>
<!--                                             <small><span class="col-green">+{{ $service_selesai_harian }}</span> Hari Ini</small> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-pink hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">Pengeluaran Sparepart Toko</div>
                                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">125</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-cyan hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">Pengeluaran Sparepart Luar</div>
                                        <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">257</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-light-green hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">Penghasilan</div>
                                        <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20">243</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-blue hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">Laba</div>
                                        <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20">1225</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
        <div class="row-clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row-clearfix">
                            <div class="col">
                                <h2>Sparepart Service</h2>
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
                                        <div class="text" style="margin-bottom: 10px">Modal Sparepart</div>
                                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">125</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-green hover-expand-effect" style="height: auto">
                                    <div class="icon">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                    <div class="content">
                                        <div class="text" style="margin-bottom: 10px">laba</div>
                                        <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">125</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row-clearfix">
                            <div class="col">
                                <h2>Grafik</h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <canvas id="bar_chart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="row-clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row-clearfix">
                            <div class="col">
                                <h2>Teknisi</h2>
                            </div>
                        </div>
                    </div>
                    <div class="body">

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Laba</th>
                                    </tr>
                                </thead>
                                <tbody>

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
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Sparepart Terpakai
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <label for="">Layar LCD OPPO</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                10 Unit dari 20 Unit
                            </div>
                        </div>
                        <label for="">Speaker Suara Samsung</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                25 Unit dari 75 Unit
                            </div>
                        </div>
                        <label for="">Baterai IPhone</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                40 Unit dari 40 Unit
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
