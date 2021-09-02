<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1,
              shrink-to-fit=no">
        <meta name="title" content="saving">
        <meta name="description" content="saving adalah aplikasi untuk manajemen keuangan pribadi. Pemasukan dan pengeluaran keuangan dapat dicatat dan dievaluasi dengan mudah.">
        <meta name="keywords" content="saving, savingid, manajemen, manajemen uang, uang, pemasukan, pengeluaran, grafik, anggaran, laporan, mengontrol uang, kelola uang, hemat, gaji, bulanan, aplikasi pengelola uang, aplikasi pengelola uang pribadi">
        <meta name="robots" content="noindex, nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="author" content="Rikzan Fernanda">

        <meta name="base_url" content="{{url('')}}">
        <meta name="csrf_token" content="{{csrf_token('')}}">
        <link rel="shortcut icon" href="{{ url('logo.png') }}" type="image/x-icon">
        <title>saving | Login</title>

        <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}"/>
        <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/mystyle.css')}}"/>
    </head>
    <body class="hold-transition login-page dark-mode">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('home') }}"><b>saving</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Masuk untuk mengontrol keuangan Anda</p>

                    @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                    <div class="text-danger">{{ $error }}</div>
                    @endforeach
                    @endif
                    <form action="{{ route('login') }}" method="post" id="login">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Email" name="email" required="required" value="{{ old('email')}}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3" id="show_hide_password">
                            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <div class="social-auth-links text-center mb-3">
                        <p>- OR -</p>
                        <a href="{{ route('social.oauth', 'github') }}" class="btn btn-block btn-primary">
                            <i class="fab fa-github mr-2"></i> Masuk dengan Github
                        </a>
                        <a href="{{ route('social.oauth', 'google') }}" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Masuk dengan Google
                        </a>
                    </div>
                    <!-- /.social-auth-links -->

                    <p class="mb-1">
                        <a href="{{ route('reset.index') }}">Lupa password</a>
                    </p>
                    <p class="mb-0">
                        Belum punya akun? <a href="{{ route('registrasi.page') }}" class="text-center">Registrasi</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/adminlte.min.js')}}"></script>
        <script src="{{asset('assets/js/toastr.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
            }
            });
            });
<?php if (session()->has('message')): ?>
                toastr.success('{{ session('message') }}');
<?php endif ?>
        </script>
    </body>
</html>
