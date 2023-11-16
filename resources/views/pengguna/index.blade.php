@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Pengguna</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('pengguna.create') }}" class="btn btn-primary">Tambah Pengguna</a>
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->nama_pengguna }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->role->nama_role }}</td>
                                            <td>
                                                <a href="{{ route('pengguna.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                                @if($data->id != 1)
                                                <form action="{{ route('pengguna.destroy', $data->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" id="hapus-button">Delete</button>
                                                </form>
                                                @endif
                                            </td>

                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            @include("layouts.includes.pagination")
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
