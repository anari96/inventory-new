@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Customer</h2>
        </div>


        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            @include('pelanggan.form')
        </form>


    </div>
@endsection
