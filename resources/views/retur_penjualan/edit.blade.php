@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Retur Penjualan</h2>
        </div>


        <form action="{{ route('retur_penjualan.update', $datas->id) }}" method="POST">
            @csrf
            @method("PUT")
            @include('retur_penjualan.form')
        </form>


    </div>
@endsection
