@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Role</h2>
        </div>


        <form action="{{ route('role.update', $id) }}" method="POST">
            @csrf
            @method('put')
            @include('role.form')
        </form>


    </div>
@endsection
