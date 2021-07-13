<html>
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
        <style>
            .container{
                /*width: 75%;*/
                margin: auto;
            }
            .table{
                border-collapse: collapse;
                display: table;
                text-align: left;
                margin-bottom: 2rem;
            }
            .table, .table tr, .table td, .table th{
                border: 1px solid black;
                padding: 0.5rem;
                text-align: left;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <h1 style="text-align: center">Bulan {{$bulan_ini}} Tahun {{$tahun_ini}}</h1>
            <h2 class="card-title">Pemasukan</h2>
            <table id="masuk" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Uang Masuk</th>
                        <th>Bank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($masuk as $val)
                    <tr>
                        <td>{{$val->created_at}}</td>
                        <td>{{moneyFormat($val->jumlah)}}</td>
                        <td>{{$val->bank}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <h2 class="card-title">Pengeluaran</h2>

            <table id="keluar" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Uang Keluar</th>
                        <th>Bank</th>
                        <th>Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keluar as $val)
                    <tr>
                        <td>{{$val->created_at}}</td>
                        <td>{{moneyFormat($val->jumlah)}}</td>
                        <td>{{$val->bank}}</td>
                        <td>{{$val->anggaran}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <h2 class="card-title">Kalkulasi</h2>
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Total Uang Masuk</th>
                        <th>{{moneyFormat($total_masuk)}}</th>
                    </tr>
                    <tr>
                        <th>Total Uang Keluar</th>
                        <th>{{moneyFormat($total_keluar)}}</th>
                    </tr>
                    @foreach($banks as $val)
                    <tr>
                        <td>Saldo {{$val->nama}}</td>
                        <td>{{moneyFormat($val->saldo)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th>Total Uang Saat ini</th>
                        <th>{{moneyFormat($total)}}</th>
                    </tr>
                </tbody>

            </table>
        </div>

    </body>
</html>
