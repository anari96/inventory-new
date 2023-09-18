@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Daftar Barang</h2>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <a href="{{ route('item.create') }}" class="btn btn-primary">Tambah Barang</a>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Harga Jual</th>
                                        <th>Harga Beli</th>
                                        <th>Stok Toko</th>
                                        <th>Stok Gudang</th>
                                        <th>Retur Penjualan</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>
                                                {{$loop->index + $datas->firstItem()}}
                                            </td>
                                            <td>
                                                {{$data->nama_item}}
                                            </td>
                                            <td>
                                                {{$data->kategoriItem->nama_kategori}}
                                            </td>
                                            <td>
                                                {{number_format($data->harga_item)}}
                                            </td>
                                            <td>
                                                {{number_format($data->biaya_item)}}
                                            </td>
                                            <td>
                                                {{$data->stok}}
                                            </td>
                                            <td>
                                                {{$data->stok_gudang}}
                                            </td>
                                            <td>
                                                {{$data->total_retur_penjualan}}
                                            </td>
                                            <td>
                                                <a href="{{ route('item.edit', $data->id) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('item.destroy', $data->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" id="hapus-button">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
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
