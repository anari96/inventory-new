@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Diskon</h2>
        </div>
        <form action="{{ route('diskon.store') }}" method="POST">
            @csrf
            @include('diskon.form')
        </form>

        
    </div>
@endsection