@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Role Pengguna</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('role.create') }}" class="btn btn-primary">Tambah Role</a>
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Nama Role</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->nama_role }}</td>
                                            <td>
                                                <a href="{{ route('role.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('role.destroy', $data->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" id="hapus-button">Delete</button>
                                                </form>
                                            </td>

                                    @endforeach
                                </tbody>

                                <tfoot>
                                    @include("layouts.includes.pagination")
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
