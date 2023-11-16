@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Merk</h2>
        </div>


        <form action="{{ route('merk.update',$data->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('merk.form')
        </form>


    </div>
@endsection
