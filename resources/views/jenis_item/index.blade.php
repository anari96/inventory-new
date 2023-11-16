@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Jenis Item</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('jenis_item.create') }}" class="btn btn-primary">Tambah Jenis Item</a>
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Jenis Item</th>
                                        <th>Kategori Item</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->nama_jenis }}</td>
                                            <td>{{ $data->kategori_item->nama_kategori }}</td>
                                            <td>
                                                <a href="{{ route('jenis_item.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('jenis_item.destroy', $data->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" id="hapus-button">Delete</button>
                                                </form>
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
