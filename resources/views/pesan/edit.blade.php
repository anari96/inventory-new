@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Pesan Service</h2>
        </div>


        <form action="{{ route('pesan.update', $datas->id) }}" method="POST">
            @csrf
            @method("PUT")
            @include('pesan.form')
        </form>


    </div>
@endsection
