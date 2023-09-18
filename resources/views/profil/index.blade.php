@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Profil Toko</h2>
        </div>


        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            @method('PUT')
            @include('profil.form')
        </form>


    </div>
@endsection
