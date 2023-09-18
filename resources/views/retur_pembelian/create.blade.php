@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Retur Pembelian</h2>
        </div>


        <form action="{{ route('retur_pembelian.store') }}" method="POST">
            @csrf
            @include('retur_pembelian.form')
        </form>


    </div>
@endsection
