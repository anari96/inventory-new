@push('scripts')
    <script>

    </script>
@endpush

@push('styles')
    <style>
        .image-upload {
            width: 200px;
            height: 200px;
            background-color: gainsboro;
            display: block;
            margin: auto;
            background-size: contain;
        }
        .image-upload>input {
            display: none;
        }

        .pilih-bentuk svg {
            width: 100px;
            height: 100px;
            display: block;
            margin: auto;
        }

        .pilih-bentuk i {
            font-size: 100px;
            color:grey;
            position:absolute;
            left: 0%;
            top: 0%;
            right: 0%;
            bottom: 0%;
        }
    </style>
@endpush

<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card">
            <div class="header">
                <a href="{{ route('service.index') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="body">

                <div class="row clearfix">
                    <div class="col-md-6">
                        <b>No. Service</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <input type="text" class="form-control" readonly value="{{ $datas->no_service }}">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-6">
                        <b>Nama Pelanggan</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <input type="text" class="form-control" readonly value="{{ $datas->pelanggan->nama_pelanggan }}">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-6">
                        <b>Telepon Pelanggan</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <input type="text" class="form-control" readonly value="{{ $datas->pelanggan->telp_pelanggan }}">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-6">
                        <b>Pesan</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <textarea class="form-control" name="isi_pesan">{{ $isi_pesan }}</textarea>
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-line">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- #END# Task Info -->

    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card">
            <div class="header">
                        <p style="font-weight:bold;">Histori Pesan</p>
            </div>
            <div class="body">

               <div class="row">
                    <div class="col-md-1">
                        <p style="font-weight:bold;">No.</p>
                    </div>
                    <div class="col-md-2">
                        <p style="font-weight:bold;">Tanggal</p>
                    </div>
                    <div class="col-md-4">
                        <p style="font-weight:bold;">Isi Pesan</p>
                    </div>
                </div>
                @forelse($pesans as $pesan)
                    <div class="row">
                        <div class="col-md-1">
                            {{$loop->index + 1}}.
                        </div>
                        <div class="col-md-2">
                            {{ date("Y-m-d",strtotime($pesan->created_at)) }}
                        </div>
                        <div class="col-md-4">
                            <p>{{ $pesan->isi_pesan }}</p>
                        </div>

                    </div>
                @empty
                    <div class="row">
                        <div class="col-md-4">
                            <p>Belum ada Mengirim Pesan</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12"><hr></div>
</div>
<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12" style="text-align: right;">
    </div>
</div>
