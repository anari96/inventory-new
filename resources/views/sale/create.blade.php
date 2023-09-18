@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Sales</h2>
        </div>


        <form action="{{ route('sale.store') }}" method="POST">
            @csrf
            @include('sale.form')
        </form>


    </div>
@endsection
