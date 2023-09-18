@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Retur Pembelian</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('retur_pembelian.create') }}" class="btn btn-primary">Tambah Retur Pembelian</a>
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nomor Pembelian</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>
                                                {{$loop->index + $datas->firstItem()}}
                                            </td>
                                            <td>{{ $data->no_pembelian }}</td>
                                            <td>
                                                <a href="{{ route('retur_pembelian.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('retur_pembelian.destroy', $data->id) }}" method="POST" style="display:inline">
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
