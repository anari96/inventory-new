@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Jenis Item</h2>
        </div>


        <form action="{{ route('jenis_item.store') }}" method="POST">
            @csrf
            @include('jenis_item.form')
        </form>


    </div>
@endsection
