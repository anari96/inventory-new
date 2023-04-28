@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <!-- ChartJs -->
    <script src="{{ url('material') }}/plugins/chartjs/Chart.bundle.js"></script>


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

        $("#karyawan_id").change(function() {
            $("#filter-form").submit();
        });

        $("#kategori_item_id").change(function() {
            $("#filter-form").submit();
        });
    </script>
    @foreach ($charts as $key => $v)
        <script>
            var ctx_{{ $key }} = document.getElementById('{{ $key }}Chart');
            if (ctx_{{ $key }}) {
                new Chart(ctx_{{ $key }}, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($periodeTanggals) !!},
                        datasets: [{
                            label: ' # {{ strtoupper(implode(' ', preg_split('/(?=[A-Z])/', $key))) }}',
                            data: {!! json_encode($v) !!},
                            borderWidth: 1,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        maintainAspectRatio: false,
                    }
                });
            }
        </script>
    @endforeach
@endpush

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <form action="" id="filter-form">
                            <div class="row">
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">

                                            <input type="text" class="form-control" name="periode" id="daterange"
                                                value="{{ $periode[0] }} - {{ $periode[1] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control" name="karyawan_id" id="karyawan_id">
                                                <option value="">Semua Karyawan</option>
                                                @foreach ($karyawans as $karyawan)
                                                    <option value="{{ $karyawan->id }}" @if(old('karyawan_id',request()->karyawan_id) == $karyawan->id) selected @endif>{{ $karyawan->nama_pengguna }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">category</i>
                                        </span>
                                        <div class="form-line">
                                            <select class="form-control" name="kategori_item_id" id="kategori_item_id">
                                                <option value="">Semua Kategori</option>
                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}" @if(old('kategori_item_id',request()->kategori_item_id) == $kategori->id) selected @endif>{{ $kategori->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tab-nav-right" style="display: flex;" role="tablist">
                            <li role="presentation" class="active" style="flex: 1;">
                                <a href="#penjualan-kotor" data-toggle="tab">
                                    <p>Penjualan Kotor</p>
                                    <h3>{{ number_format($penjualanKotor) }}</h3>
                                </a>
                            </li>
                            <li role="presentation" style="flex: 1;">
                                <a href="#pengembalian" data-toggle="tab">
                                    <p>Pengembalian</p>
                                    <h3>{{ number_format($pengembalian) }}</h3>
                                </a>
                            </li>
                            <li role="presentation" style="flex: 1;">
                                <a href="#diskon" data-toggle="tab">
                                    <p>Diskon</p>
                                    <h3>{{ number_format($diskon) }}</h3>
                                </a>
                            </li>
                            <li role="presentation" style="flex: 1;">
                                <a href="#penjualan-bersih" data-toggle="tab">
                                    <p>Penjualan Bersih</p>
                                    <h3>
                                        {{ number_format($penjualanBersih) }}
                                    </h3>
                                </a>
                            </li>
                            <li role="presentation" style="flex: 1;">
                                <a href="#laba-kotor" data-toggle="tab">
                                    <p>Laba Kotor</p>
                                    <h3>{{ number_format($labaKotor) }}</h3>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="penjualan-kotor">
                                <b>Penjualan Kotor</b>
                                <div style="height: 300px;">
                                    <canvas id="penjualanKotorChart"></canvas>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="pengembalian">
                                <b>Pengembalian</b>
                                <div style="height: 300px;">
                                    <canvas id="pengembalianChart"></canvas>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="diskon">
                                <b>Diskon</b>
                                <div style="height: 300px;">
                                    <canvas id="diskonChart"></canvas>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="penjualan-bersih">
                                <b>Penjualan Bersih</b>
                                <div style="height: 300px;">
                                    <canvas id="penjualanBersihChart"></canvas>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="laba-kotor">
                                <b>Laba Kotor</b>
                                <div style="height: 300px;">
                                    <canvas id="labaKotorChart"></canvas>
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
                        <h2>Riwayat Transaksi</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Penjualan Kotor</th>
                                        <th>Pengembalian</th>
                                        <th>Diskon</th>
                                        <th>Penjualan Bersih</th>
                                        <th>Harga Pokok</th>
                                        <th>Laba Kotor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periodeTanggals as $key => $tanggal)
                                        <tr>
                                            <td>
                                                {{ $tanggal }}
                                            </td>
                                            <td>
                                                {{ number_format($charts['penjualanKotor'][$key]) }}
                                            </td>
                                            <td>
                                                {{ number_format($charts['pengembalian'][$key]) }}
                                            </td>
                                            <td>
                                                {{ number_format($charts['diskon'][$key]) }}
                                            </td>
                                            <td>
                                                {{ number_format($charts['penjualanBersih'][$key]) }}
                                            </td>
                                            <td>
                                                {{ number_format($charts['hargaPokok'][$key]) }}
                                            </td>
                                            <td>
                                                {{ number_format($charts['labaKotor'][$key]) }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>


    </div>
@endsection
