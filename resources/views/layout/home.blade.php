<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>saving</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link rel="shortcut icon" href="{{ url('logo.png') }}" type="image/x-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!--<link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">-->
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
        <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">

        <!-- =======================================================
        * Template Name: Day - v2.2.1
        * Template URL: https://bootstrapmade.com/day-multipurpose-html-template-for-free/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>

    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center">

                <h1 class="logo mr-auto"><a href="{{ route('home')}}">saving</a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

                <nav class="nav-menu d-none d-md-block">
                    <ul>
                        <li class="active"><a href="{{ route('home')}}">Home</a></li>
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li>
                            <a class="" href="" data-toggle="modal" data-target="#modalRegistrasi">Registrasi</a>
                        </li>
                        @if(auth()->user())
                        <li>
                            <a class="" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        @else
                        <li>
                            <a class="" href="" data-toggle="modal" data-target="#modalLogin">Login</a>
                        </li>
                        @endif
                    </ul>
                </nav><!-- .nav-menu -->

            </div>
        </header><!-- End Header -->
        <!-- Modal login -->
        <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Username atau Email</label>
                                <input type="text" class="form-control" name="email" required="required" value="{{old('email')}}">
                                @error('email')<small class="form-text text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input class="form-control" type="password" name="password" required="required">
                                    <div class="input-group-addon">
                                        <a href=""><i class="btn btn-primary fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember">Remember Me</label>
                                    </label>
                                </div>
                            </div>
                            <a href="{{ route('reset.index') }}" class="btn btn-link text-decoration-none">Forgot Password</a>
                            <div class="text-right">
                                <button type="submit" class="btn btn-link text-decoration-none">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal registrasi -->
        <div class="modal fade" id="modalRegistrasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user.store') }}">
                            @csrf
                            <input type="hidden" name="id_role" value="3">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" required="required" value="{{old('nama')}}">
                                @error('nama')<small class="form-text text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" required="required" value="{{old('email')}}">
                                @error('email')<small class="form-text text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" name="pekerjaan" value="{{old('pekerjaan')}}">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" value="{{old('alamat')}}">

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input class="form-control" type="password" name="password" required="required">
                                    <div class="input-group-addon">
                                        <a href=""><i class="btn btn-primary fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-link text-decoration-none">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

        <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="container">
                <div class="copyright">
                    &copy; Copyright <strong><span>saving</span></strong>. All Rights Reserved
                </div>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top"><i class="bx bx-upvote"></i></a>
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
        <!--<script src="assets/vendor/php-email-form/validate.js"></script>-->
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/venobox/venobox.min.js"></script>
        <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>
        <script>
            @if (session()->has('message'))
                    alert('{{ session('message') }}');
            @endif
        </script>

    </body>

</html>