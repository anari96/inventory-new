@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Teknisi</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('teknisi.create') }}" class="btn btn-primary">Tambah Teknisi</a>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Nama Teknisi</th>
                                        <th>No. Telepon Teknisi</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->nama_teknisi }}</td>
                                            <td>{{ $data->telp_teknisi }}</td>
                                            <td>
                                                <a href="{{ route('teknisi.edit', [$id = $data->id]) }}" class="btn btn-primary">Edit</a>
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
