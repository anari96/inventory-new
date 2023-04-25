@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Barang</h2>
        </div>


        <form action="{{ route('item.store') }}" method="POST">
            @csrf
            @include('item.form')
        </form>

        
    </div>
@endsection