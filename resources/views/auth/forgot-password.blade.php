<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="base_url" content="{{url('')}}">
        <link rel="shortcut icon" href="{{ url('logo.png') }}" type="image/x-icon">
        <title>saving</title>
        <!--style-->
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <form action="{{ route('reset.email')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email">
                                    <small id="emailHelp" class="form-text text-muted"></small>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-link text-decoration-none">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    </body>
</html>
