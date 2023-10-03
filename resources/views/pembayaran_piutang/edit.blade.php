@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Pembayaran Piutang</h2>
        </div>


        <form action="{{ route('pembayaran_piutang.update', $datas->id) }}" method="POST">
            @csrf
            @method("PUT")
            @include('pembayaran_piutang.form')
        </form>


    </div>
@endsection
