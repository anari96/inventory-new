@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tambah Teknisi</h2>
        </div>

        <form action="{{ route('profil.update',$data->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('pengaturan.form')
        </form>

    </div>
@endsection
