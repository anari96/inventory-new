@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Pengguna</h2>
        </div>


        <form action="{{ route('pengguna.store') }}" method="POST">
            @csrf
            @include('pengguna.form')
        </form>


    </div>
@endsection
