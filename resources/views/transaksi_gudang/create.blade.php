@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Transaksi Gudang</h2>
        </div>


        <form action="{{ route('transaksi_gudang.store') }}" method="POST">
            @csrf
            @include('transaksi_gudang.form')
        </form>


    </div>
@endsection
