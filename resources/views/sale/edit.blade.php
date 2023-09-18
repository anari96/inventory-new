@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Sales</h2>
        </div>


        <form action="{{ route('sale.update',$datas->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('sale.form')
        </form>


    </div>
@endsection
