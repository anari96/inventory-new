@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Edit Jenis Item</h2>
        </div>


        <form action="{{ route('jenis_item.update',$datas->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('jenis_item.form')
        </form>


    </div>
@endsection
