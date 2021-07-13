<html>
    <head>
        <title>saving</title>
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Click the link below</div>
                        <div class="card-body">

                            <a href="{{ route('reset.password', $token)}}">{{ route('reset.password', $token)}}</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    </body>
</html>
