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
</head>

    <style>
        html, body{
            padding:0;
            height: 100%;
        }
        .dark-purple-bg{
            background-color: #ba68c8;
            min-height:100%;
            height:100%;
        }
        .white-color{
            color: white;
        }

       .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
        }
        .form-signin .checkbox {
        font-weight: 400;
        }
        .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
        }
        .form-signin .form-control:focus {
        z-index: 2;
        }
        .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        }




    </style>
    <body class="login-page">

            <div class="row" style="margin:0;height:100%">
                <div class="col-md-6 dark-purple-bg">
                    <div class="form-signin" style="width:100%;margin-top :15em">
                        <h2 style="margin-left:-9em;color:white;width:25em;font-weight:bold"></h2>
                        <h4 style="margin-left:-15em;color:white;width:25em"></h4>
                    </div>
                    <div class="form-signin" style="width:100%;margin-top :15em">
                        <h2 style="margin-left:-9em;color:white;width:25em;font-weight:bold">Selamat Datang di {{ env("APP_NAME") }}</h2>
                        <h4 style="margin-left:-15em;color:white;width:25em">Anggur Cell Siap Melayani dan Memperbaiki Gadget Kesayangan Anda</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="form-signin" style="margin-top :15em" method="POST" action="{{ route('login.auth') }}">
                    @csrf
                        <h1 class="h3 mb-3 font-weight-normal" style="color:#9e35af;font-weight:bolder;font-size:4.5em">Log In</h1>
                        <h1 class="h3 mb-3 font-weight-normal" style="color:#9e35af;font-size:3em"></h1>
                        <label for="inputEmail" class="sr-only">Email address</label>
                        <input type="email" id="inputEmail" class="form-control" style="margin-bottom:1.2em" placeholder="Email address" name="email" required autofocus>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                        <div class="checkbox mb-3">
                            <label>
                            <input type="checkbox" name="rememberme" value="remember-me"> Remember me
                            </label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" style="background:#9e35af" type="submit">Sign in</button>
                    </form>
                </div>
            </div>

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
