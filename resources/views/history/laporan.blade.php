@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fas fa-inbox"></i></span>

        <div class="info-box-content">
            <p>Anda dapat menyimpan laporan ini dalam bentuk pdf dengan mengeklik tombol download</p>
        </div>
    </div>
    
    <form method="GET" action="{{ route('history.laporan') }}">
        <div class="d-flex flex-row-reverse bd-highlight">
            <div class="bd-highlight">
                <button type="submit" class="btn btn-info text-decoration-none">Buat Laporan</button>
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
    <div class="card-header">
        <h5 class="card-title">Pemasukan</h5>
        <div class="card-tools mr-0">
            <button type="button" class="btn btn-tool">
                <a href="{{ route('history.download', ['tahun' => $tahun_ini, 'bulan' => $bulan_ini])}}">
                    <i class="fas fa-download"></i> Download
                </a>
            </button>
        </div>
    </div>
    <div class="card">
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

    <div class="card-header">
        <h5 class="card-title">Pengeluaran</h5>
        <div class="card-tools mr-0">
            <button type="button" class="btn btn-tool">
            </button>
        </div>
    </div>
    <div class="card">
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
                        <td>{{$val->anggaran}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

    <div class="card-header">
        <h5 class="card-title">Kalkulasi</h5>
        <div class="card-tools mr-0">
            <button type="button" class="btn btn-tool">
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

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
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Uang Saat ini</th>
                        <th colspan="2">{{moneyFormat($total)}}</th>
                    </tr>
                </tfoot>

            </table>
        </div>

    </div>


</div>

@endsection