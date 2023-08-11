@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Penjualan</h2>
        </div>


        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf
            @include('penjualan.form')
        </form>


    </div>
@endsection
