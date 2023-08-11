@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Pembelian</h2>
        </div>


        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            @include('pembelian.form')
        </form>


    </div>
@endsection
