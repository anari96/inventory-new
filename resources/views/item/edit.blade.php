@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Barang</h2>
        </div>


        <form action="{{ route('item.update',$data->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('item.form')
        </form>

        
    </div>
@endsection