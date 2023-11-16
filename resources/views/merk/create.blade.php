@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Merk</h2>
        </div>


        <form action="{{ route('merk.store') }}" method="POST">
            @csrf
            @include('merk.form')
        </form>


    </div>
@endsection
