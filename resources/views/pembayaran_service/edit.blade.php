@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Pembayaran Service</h2>
        </div>


        <form action="{{ route('pembayaran_service.update', $datas->id) }}" method="POST">
            @csrf
            @method("PUT")
            @include('pembayaran_service.form')
        </form>


    </div>
@endsection
