@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Pelanggan</h2>
        </div>


        <form action="{{ route('pelanggan.update',$data->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('pelanggan.form')
        </form>

    </div>
@endsection
