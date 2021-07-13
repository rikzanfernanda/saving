<html>
    <head>
        <title>saving</title>
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-body">
                            <form method="POST" action="{{ route('reset.update.password')}}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" class="form-control" name="password">
                                    <small class="form-text text-muted"></small>
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
