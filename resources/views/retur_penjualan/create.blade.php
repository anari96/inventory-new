@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Retur Penjualan</h2>
        </div>


        <form action="{{ route('retur_penjualan.store') }}" method="POST">
            @csrf
            @include('retur_penjualan.form')
        </form>


    </div>
@endsection
