@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Diskon</h2>
        </div>
        <form action="{{ route('diskon.update',$data->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('diskon.form')
        </form>

        
    </div>
@endsection