@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Service</h2>
        </div>


        <form action="{{ route('sparepart.store') }}" method="POST">
            @csrf
            @include('sparepart.form')
        </form>


    </div>
@endsection
