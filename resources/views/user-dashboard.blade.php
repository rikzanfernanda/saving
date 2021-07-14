@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="card bg-success" id="dashboard-thanks">
        <div class="text-right text-white">
            <div class="card-tools">
                <button type="button" class="btn py-0" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body py-0">
            <div class="info-box-content">
                <p>Keuangan Anda akan lebih rapih dan terkelola dengan baik dengan aplikasi saving</p>
                <p>Terima kasih telah menggunkan layanan kami.</p>
            </div>
        </div>
    </div>

    <div id="dashboard-bank">
        <div class="row mb-4">
            @foreach($banks as $opt)
            <div class="col-lg-3 col-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $opt->nama }}</h3>

                        <p>{{ moneyFormat($opt->saldo) }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-save"></i>
                    </div>
                    <a href="{{ route('bank.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
            <h5 class="m-0">Pemasukan dan Pengeluaran Anda Selama Tahun {{ date('Y') }}</h5>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="text-md-right">
                <a href="" class="" data-toggle="modal" data-target="#modalCreatePemasukan">Buat Pemasukan</a>
                <a href="" class="ml-3" data-toggle="modal" data-target="#modalCreatePengeluaran">Buat Pengeluaran</a>
            </div>
        </div>
        <div class="card-body">
            <canvas id="myChart" style="min-height:30rem"></canvas>
        </div>
        <div class="card-footer">
            <form method="GET" action="{{ route('history.laporan') }}" class="">
                <div class="d-flex flex-row-reverse bd-highlight">
                    <div class="px-md-2 bd-highlight">
                        <!--<a href="{{route('history.laporan', ['1', '2021'])}}" id="lapor" class="btn btn-info">Buat Laporan</a>-->
                        <button type="submit" class="btn btn-info text-decoration-none">Buat</button>
                    </div>
                    <div class="px-2 px-md-2 bd-highlight">
                        <div class="form-group">
                            <select class="form-control" name="tahun">
                                @foreach($tahun as $opt)
                                <option value="{{$opt}}" class="form-control">{{$opt}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="px-md-2 bd-highlight">
                        <div class="form-group">
                            <select class="form-control" name="bulan">
                                @foreach($bulan as $key => $opt)
                                <option value="{{$key+1}}" class="form-control">{{$opt}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-6 col-md-3 border-right">
                    <div class="description-block">
                        <span class="description-percentage text-success"><i class="fas fa-download"></i></span>
                        <h6 class="description-header mb-2">{{ moneyFormat($total_masuk)}}</h6>
                        <span class="description-text">TOTAL SEMUA PEMASUKAN</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 border-right" id="dashboard-total">
                    <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-upload"></i></span>
                        <h6 class="description-header mb-2">{{ moneyFormat($total_keluar)}}</h6>
                        <span class="description-text">TOTAL SEMUA PENGELUARAN</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 border-right">
                    <div class="description-block">
                        <span class="description-percentage text-success"><i class="fas fa-download"></i></span>
                        <h6 class="description-header mb-2">{{ moneyFormat($bln_masuk)}}</h6>
                        <span class="description-text">PEMASUKAN BULAN INI</span>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-upload"></i></span>
                        <h6 class="description-header mb-2">{{ moneyFormat($bln_keluar)}}</h6>
                        <span class="description-text">PENGELUARAN BULAN INI</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 h-100">
                    <div class="info-box mb-2 bg-warning h-100">
                        <span class="info-box-icon d-md-flex"><i class="fas fa-money-check-alt"></i></span>

                        <div class="info-box-content">
                            <p>Anda menyimpan <b>{{ moneyFormat($total_save) }}</b> dari total semua pemasukan dan pengeluaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 h-100">
                    <div class="info-box mb-2 bg-success h-100">
                        <span class="info-box-icon d-md-flex"><i class="fas fa-money-check"></i></span>

                        <div class="info-box-content">
                            <p>Anda menyimpan <b>{{ moneyFormat($bln_save) }}</b> dari total pemasukan dan pengeluaran bulan ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5>Anggaran</h5>
    <div class="row mb-4">
        <div class="col-md-6">
            <p>Anggaran dan total semua uang yang Anda keluarkan untuk anggaran tersebut</p>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="total_anggaran" style="width:100%">
                        <thead>
                            <tr>
                                <th>Anggaran</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($uang_anggaran as $opt)
                            <tr>
                                <td>{{$opt->nama}}</td>
                                <td>{{moneyFormat($opt->jumlah)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('anggaran.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <p>Anggaran dan total uang yang Anda keluarkan untuk anggaran tersebut selama bulan ini</p>
            <div class="card mb-0">
                <div class="card-body">
                    <table class="table table-hover" id="bln_anggaran" style="width:100%">
                        <thead>
                            <tr>
                                <th>Anggaran</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bln_uang_anggaran as $opt)
                            <tr>
                                <td>{{$opt->nama}}</td>
                                <td>{{moneyFormat($opt->jumlah)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('anggaran.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h5 class="mb-3">History Terkini</h5>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="total_anggaran" style="width:100%">
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $opt)
                            <tr>
                                <td>{{$opt->kegiatan}}</td>
                                <td>{{$opt->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('history.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>


</div>

<!-- create pemasukan -->
<div class="modal fade" id="modalCreatePemasukan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('bank.masuk') }}" id="formCreatePemasukan">
                    @csrf
                    <div class="form-group">
                        <label for="jumlah">Jumlah Uang</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required="required">
                    </div>
                    <div class="form-group">
                        <label for="bank">Bank</label>
                        <select id="bank" name="bank" class="form-control">
                            @foreach($banks as $opt)
                            <option value="{{$opt->id}}" class="form-control">{{$opt->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-link text-decoration-none">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- create pengeluaran -->
<div class="modal fade" id="modalCreatePengeluaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('bank.keluar') }}" id="formCreatePengeluaran">
                    @csrf
                    <div class="form-group">
                        <label for="jumlah">Jumlah Uang</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required="required">
                    </div>
                    <div class="form-group">
                        <label for="bank">Bank</label>
                        <select id="bank" name="bank" class="form-control">
                            @foreach($banks as $opt)
                            <option value="{{$opt->id}}" class="form-control">{{$opt->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="anggaran">Anggaran</label>
                        <select id="anggaran" name="anggaran" class="form-control">
                            <option class="form-control"></option>
                            @foreach($anggarans as $opt)
                            <option value="{{$opt->id}}" class="form-control">{{$opt->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-link text-decoration-none">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

