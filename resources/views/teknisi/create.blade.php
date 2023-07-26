@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Teknisi</h2>
        </div>

        <form action="{{ route('teknisi.store') }}" method="POST">
            @csrf
            @include('teknisi.form')
        </form>

    </div>
@endsection
