<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | {{ env("APP_NAME") }}</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ url('material') }}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ url('material') }}/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ url('material') }}/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ url('material') }}/plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ url('material') }}/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ url('material') }}/css/themes/all-themes.css" rel="stylesheet" />

    <link href="{{ url('material') }}/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    @stack('styles')
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    @include('layouts.includes.topbar')
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        @include('layouts.includes.leftbar')
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        @include('layouts.includes.rightbar')
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        @if (session('error'))
            <div class="alert bg-red">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert bg-green">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </section>

    <!-- Jquery Core Js -->
    <script src="{{ url('material') }}/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ url('material') }}/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="{{ url('material') }}/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    

    <!-- Slimscroll Plugin Js -->
    <script src="{{ url('material') }}/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ url('material') }}/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ url('material') }}/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ url('material') }}/plugins/raphael/raphael.min.js"></script>
    <script src="{{ url('material') }}/plugins/morrisjs/morris.js"></script>



    <script src="{{ url('material') }}/js/admin.js"></script>

    @stack('scripts')
</body>

</html>
