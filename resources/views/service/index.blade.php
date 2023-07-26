@extends('layouts.app')

@push('scripts')
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
                                            <td>
                                                <a href="{{ route('service.edit', [$id = $data->id]) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('service.destroy', $data->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <div class="text-center">
                                                {{ $datas->links() }}
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
