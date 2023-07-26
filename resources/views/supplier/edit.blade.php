@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Teknisi</h2>
        </div>

        <form action="{{ route('supplier.update', ['id'=> $data->$id]) }}" method="POST">
            @csrf
            @method('PUT')
            @include('supplier.form')
        </form>

    </div>
@endsection
