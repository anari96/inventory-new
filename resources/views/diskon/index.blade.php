@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Diskon</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('diskon.create') }}" class="btn btn-primary">Tambah Diskon</a>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>Nama Diskon</th>
                                        <th>Jenis Diskon</th>
                                        <th>Nilai Diskon</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>
                                                {{$data->nama_diskon}}
                                            </td>
                                            <td>
                                                {{$data->jenis_diskon}}
                                            </td>
                                            <td>
                                                @if($data->jenis_diskon == "persen")
                                                {{$data->nilai_diskon}}%
                                                @else
                                                {{number_format($data->nilai_diskon)}}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('diskon.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('diskon.destroy', $data->id) }}" method="POST" style="display:inline">
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
                                        <td colspan="4">
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