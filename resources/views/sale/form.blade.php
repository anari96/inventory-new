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
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="header">
                <a href="{{ route('pengguna.index') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-3">
                        <b>Nama Sales</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <input type="text" class="form-control" name="nama_sales" value="@if(isset($datas)) {{$datas->nama_sales}} @endif">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-3">
                        <b>Alamat</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <input type="text" class="form-control" name="alamat" value="@if(isset($datas)) {{$datas->alamat}} @endif">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-3">
                        <b>Kontak</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <input type="text" class="form-control" name="kontak" value="@if(isset($datas)) {{$datas->kontak}} @endif">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-line">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
</div>


<div class="row">
    <div class="col-md-12"><hr></div>
</div>
<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12" style="text-align: right;">
    </div>
</div>
