
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{ env("APP_NAME") }}</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ url('material') }}/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ url('material') }}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ url('material') }}/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ url('material') }}/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
<!--     <link href="{{ url('material') }}/css/style.css" rel="stylesheet"> -->
    <style>
        body{
            width:70%;
            margin-left:auto;
            margin-right:auto;
        }
    </style>
</head>

<body class="login-page">

<div class="col-md-12">

    <form action="{{ route('service.guest.store') }}" method="POST">
            @csrf
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <h1 class="h3 mb-3 font-weight-normal" style="color:#9e35af;font-weight:bolder;font-size:4.5em">Service Pelanggan Baru</h1>
                    <h2 class="card-inside-title">Pelanggan</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">
                            <div id="form_pelanggan">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="nama" id="nama_pelanggan" class="form-control" placeholder="Nama">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="alamat" id="alamat_pelanggan" class="form-control" placeholder="Alamat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="kontak" id="telp_pelanggan" class="form-control" placeholder="Kontak">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <h2 class="card-inside-title">Detail Gadget</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="merk" class="form-control"  placeholder="Merk" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="tipe" class="form-control"  placeholder="Tipe" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="imei1" class="form-control" placeholder="IMEI 1" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="imei2" class="form-control" placeholder="IMEI 2">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="col-md-12">
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Detail Service
                    </h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">

                            <div class="form-group">
                                <div class="form-line">
                                    <h4 class="card-inside-title">Untuk Klaim Garansi</h4>
                                    <input name="garansi" type="radio" id="radio_1" value='1' checked>
                                    <label for="radio_1">Ya</label>
                                    <input name="garansi" type="radio" id="radio_2" value='0'>
                                    <label for="radio_2">Tidak</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="kerusakan" class="form-control" class="form-control" placeholder="Kerusakan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="deskripsi" class="form-control" class="form-control" placeholder="Deskripsi" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="kelengkapan" class="form-control" class="form-control"  placeholder="Kelengkapan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="width:100%;background:#9e35af;border:none;">Simpan</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</form>
        <!-- Jquery Core Js -->
        <script src="{{ url('material') }}/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core Js -->
        <script src="{{ url('material') }}/plugins/bootstrap/js/bootstrap.js"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="{{ url('material') }}/plugins/node-waves/waves.js"></script>

        <!-- Validation Plugin Js -->
        <script src="{{ url('material') }}/plugins/jquery-validation/jquery.validate.js"></script>

        <!-- Custom Js -->
        <script src="{{ url('material') }}/js/admin.js"></script>
        <script src="{{ url('material') }}/js/pages/examples/sign-in.js"></script>
    </body>

</html>
