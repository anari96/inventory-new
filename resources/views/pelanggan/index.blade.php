@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Pelanggan</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Customer</a>
                    </div>
                    <div class="body">
                        @include('layouts.includes.filter')
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>No. Telepon</th>
                                        <th>Alamat</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->nama_pelanggan }}</td>
                                            <td>{{ $data->telp_pelanggan }}</td>
                                            <td>{{ $data->alamat_pelanggan }}</td>
                                            <td>
                                                <a href="{{ route('pelanggan.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('pelanggan.destroy', $data->id) }}" method="POST" style="display:inline">
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
                                            @if($datas->currentPage() != 1)
                                                <a href="{{ $datas->previousPageUrl() }}" @if($datas->currentPage() == 1) style="display:none;" @endif > Previous </a>
                                                <a href="{{ $datas->url(1) }}">1</a>
                                            @endif
                                            @for($i = max($datas->currentPage() - 5,2); $i < $datas->currentPage(); $i++ )
                                                <a href="{{ $datas->url($i) }}">{{ $i }}</a>
                                            @endfor
                                            <a href="{{ $datas->url($datas->currentPage()) }}" style="font-weight: bold"> {{$datas->currentPage()}} </a>
                                            @if($datas->currentPage() != $datas->lastPage() && $datas->currentPage() !=  $datas->lastPage() - 1)
                                                @for($i = $datas->currentPage() + 1; $i < $datas->currentPage() + 5; $i++ )
                                                    @if($i < $datas->lastPage() )
                                                        <a href="{{ $datas->url($i) }}">{{ $i }}</a>
                                                    @endif
                                                @endfor
                                            @endif
                                            @if($datas->currentPage() != $datas->lastPage())
                                                <a href="{{$datas->url($datas->lastPage())}}">{{$datas->lastPage()}}</a>
                                                <a href="{{ $datas->nextPageUrl() }}"  > Next </a>
                                            @endif
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
