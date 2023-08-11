@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Penjualan</h2>
        </div>


        <form action="{{ route('pembelian.update', $datas->id) }}" method="POST">
            @csrf
            @method("PUT")
            @include('pembelian.form')
        </form>


    </div>
@endsection
