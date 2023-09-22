@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Retur Pembelian</h2>
        </div>


        <form action="{{ route('retur_pembelian.update', $datas->id) }}" method="POST">
            @csrf
            @method("put")
            @include('retur_pembelian.form')
        </form>


    </div>
@endsection
