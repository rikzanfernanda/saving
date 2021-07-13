<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,
              shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="base_url" content="{{url('')}}">
        <link rel="shortcut icon" href="{{ url('logo.png') }}" type="image/x-icon">
        <title>saving</title>
        <!--style-->
        <link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}"/>
        <!--<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>-->
        <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        @if(isset($css))
        @foreach ($css as $style)
        <link rel="stylesheet" href="{{asset('assets/css'). $style}}"/>
        @endforeach
        @endif

    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-2">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="brand-link">
                    <img src="{{ url('logo.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">saving</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-columns"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('bank.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-donate"></i>
                                    <p>
                                        Bank
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('anggaran.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-share-square"></i>
                                    <p>
                                        Anggaran
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('history.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>
                                        History
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('history.laporan') }}" class="nav-link">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>
                                        Laporan
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('bantuan.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-question-circle"></i>
                                    <p>
                                        Bantuan
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('feedback.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-comment-dots"></i>
                                    <p>
                                        Feedback
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('akun') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user-circle"></i>
                                    <p>
                                        Akun
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
        </div>

        <nav class="main-header navbar navbar-expand navbar-dark">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-white">Selamat datang, <b>{{ auth()->user()->nama }}</b></span>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link text-white text-bold">Total: {{ moneyFormat($total)}}</span>
                </li>
                <li class="nav-item d-sm-inline-block">
                    <a href="{{ route('petunjuk') }}" class="nav-link">Petunjuk</a>
                </li>
                <li class="nav-item d-sm-inline-block">
                    <a href="{{ route('logout') }}" class="nav-link">Logout</a>
                </li>
            </ul>

        </nav>

        <div class="content-wrapper mt-3">
            <section class="content">

                @yield('content')

            </section>
        </div>

        <footer class="main-footer mt-4">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-md-inline-block">
                rikzanfernanda@gmail.com
            </div>
            <div class="d-sm-inline-block d-md-none">
                rikzanfernanda@gmail.com
            </div>
        </footer>



        <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/adminlte.min.js')}}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        @if(isset($js))
        @foreach ($js as $script)
        <script src="{{asset('assets/js'). $script}}"></script>
        @endforeach
        @endif
        <script>
            toastr.options = {
            "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "200",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
            }
            //message with toastr
            @if (session()->has('success'))
                    toastr.success('{{ session('success') }}', 'BERHASIL!');
            @elseif(session()->has('error'))
                    toastr.error('{{ session('error') }}', 'GAGAL!');
            @elseif(session()->has('info'))
                    toastr.info('{{ session('info') }}', 'INFO!');
            @elseif(session()->has('info'))
                    toastr.warning('{{ session('warning') }}', 'PERINGATAN!');
            @endif
        </script>
    </body>
</html>