@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Kategori</h2>
        </div>


        <form action="{{ route('kategori-item.update',$data->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('kategori-item.form')
        </form>

        
    </div>
@endsection