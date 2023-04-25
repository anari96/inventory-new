@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Kategori</h2>
        </div>


        <form action="{{ route('kategori-item.store') }}" method="POST">
            @csrf
            @include('kategori-item.form')
        </form>

        
    </div>
@endsection