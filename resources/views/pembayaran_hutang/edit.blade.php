@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Pembayaran Hutang</h2>
        </div>


        <form action="{{ route('pembayaran_hutang.update', $datas->id) }}" method="POST">
            @csrf
            @method("PUT")
            @include('pembayaran_hutang.form')
        </form>


    </div>
@endsection
