<html>
    <head>
        <title>saving</title>
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
    </body>
</html>
