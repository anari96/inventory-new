@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Pengguna</h2>
        </div>


        <form action="{{ route('pengguna.update',$datas->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('pengguna.form')
        </form>


    </div>
@endsection
