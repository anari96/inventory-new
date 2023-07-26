@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Supplier</h2>
        </div>


        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            @include('supplier.form')
        </form>


    </div>
@endsection
