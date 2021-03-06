@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3 mx-3 mx-md-0">Laporan</h5>
    <div class="info-box mb-3 bg-success shadow-sm">
        <span class="info-box-icon"><i class="fas fa-inbox"></i></span>

        <div class="info-box-content">
            <p>Anda dapat menyimpan laporan ini dalam bentuk pdf dengan mengeklik tombol download</p>
        </div>
    </div>

    <form method="GET" action="{{ route('history.laporan') }}" class="mx-3 mx-md-0">
        <div class="d-flex flex-row-reverse bd-highlight">
            <div class="bd-highlight">
                <button type="submit" class="btn btn-info text-decoration-none">Buat</button>
            </div>

            <div class="form-group px-2">
                <select class="form-control" name="tahun">
                    @foreach($tahun as $opt)
                    @if($opt == $tahun_ini)
                    <option value="{{$opt}}" class="form-control" selected="selected">{{$opt}}</option>
                    @else
                    <option value="{{$opt}}" class="form-control">{{$opt}}</option>
                    @endif
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <select class="form-control" name="bulan">
                    @foreach($bulan as $key => $opt)
                    @if($key+1 == $bulan_ini)
                    <option value="{{$key+1}}" class="form-control" selected="selected">{{$opt}}</option>
                    @else
                    <option value="{{$key+1}}" class="form-control">{{$opt}}</option>
                    @endif
                    @endforeach
                </select>
            </div>

        </div>
    </form>

    <div class="text-right">
        <button type="button" class="btn">
            <a href="{{ route('history.download', ['tahun' => $tahun_ini, 'bulan' => $bulan_ini])}}">
                <i class="fas fa-download"></i> Download
            </a>
        </button>
    </div>

    <div class="row mx-0">
        <div class="col-md-8 px-0 pr-md-2">
            <div class="laporan border border-light mb-3">
                <div class="bg-light px-3 px-md-4 py-2">
                    <h5>Pemasukan</h5>
                </div>
                <div class="px-3 px-md-4 py-2 mb-4">
                    @foreach($masuk as $val)
                    <div class="row mx-0 py-2">
                        <div class="col-9 pl-0 pr-4">
                            <div class="border-bottom border-light">{{$val->created_at}} - {{$val->bank}}</div>
                        </div>
                        <div class="col-3 border-bottom border-light text-right pr-0">{{moneyFormat($val->jumlah)}}</div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-light px-3 px-md-4 py-2">
                    <h5>Pengeluaran</h5>
                </div>
                <div class="px-3 px-md-4 py-2 mb-4">
                    @foreach($keluar as $val)
                    <div class="row mx-0 py-2">
                        <div class="col-9 pl-0 pr-4">
                            <div class="border-bottom border-light">
                                {{$val->created_at}} - {{$val->bank}} <span class="text-info">( {{ \Illuminate\Support\Str::limit($val->anggaran, 20, $end='...') }} )</span>
                            </div>
                        </div>
                        <div class="col-3 border-bottom border-light text-right pr-0">{{moneyFormat($val->jumlah)}}</div>
                    </div>
                    @endforeach
                </div>
            </div>

<!--            pemasukan
            <div class="card">
                <div class="card-header">
                    Pemasukan
                </div>
                <div class="card-body">
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
                </div>

            </div>
            end pemasukan

            pengeluaran
            <div class="card">
                <div class="card-header">
                    Pengeluaran
                </div>
                <div class="card-body">

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
                                <td>{{ \Illuminate\Support\Str::limit($val->anggaran, 20, $end='...') }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
            end pengeluaran-->
        </div>
        <div class="col-md-4 px-0 pl-md-2">
            <!--kalkulasi-->
            <div class="card">
                <div class="card-header">
                    Kalkulasi
                </div>
                <div class="card-body">

                    <table class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Total Uang Masuk</th>
                                <th class="text-right">{{moneyFormat($total_masuk)}}</th>
                            </tr>
                            <tr>
                                <th>Total Uang Keluar</th>
                                <th class="text-right">{{moneyFormat($total_keluar)}}</th>
                            </tr>
                            @foreach($banks as $val)
                            <tr>
                                <td>Saldo {{$val->nama}}</td>
                                <td class="text-right">{{moneyFormat($val->saldo)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total Uang Saat ini</th>
                                <th colspan="2" class="text-right">{{moneyFormat($total)}}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
            <!--end kalkulasi-->
        </div>
    </div>

</div>

@endsection