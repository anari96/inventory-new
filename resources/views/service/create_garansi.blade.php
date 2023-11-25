@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Service</h2>
        </div>


        <form action="{{ route('service.store') }}" method="POST">
            @csrf
            @include('service.form')
            <input type="hidden" name="garansi" value="{{ $garansi }}">
        </form>


    </div>
@endsection
