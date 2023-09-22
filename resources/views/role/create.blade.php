@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Role</h2>
        </div>


        <form action="{{ route('role.store') }}" method="POST">
            @csrf
            @include('role.form')
        </form>


    </div>
@endsection
