@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="card bg-success mb-3 mb-md-4 shadow" id="dashboard-thanks">
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
        <div class="row mb-3">
            @foreach($banks as $opt)
            <div class="col-lg-3 col-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 class="text-truncate w-75 m-auto m-md-0">{{ $opt->nama }}</h3>

                        <p>{{ moneyFormat($opt->saldo) }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-donate"></i>
                    </div>
                    <a href="{{ route('bank.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 mb-2 mb-md-0">
                    Pemasukan dan Pengeluaran Anda Selama Tahun {{ date('Y') }}
                </div>
                <div class="col-md-6">
                    <div class="text-right">
                        <a href="{{ route('bank.create.pengeluaran') }}" class="btn btn-outline-info mr-md-2"><i class="fas fa-plus"></i> Pengeluaran</a>
                        <a href="{{ route('bank.create.pemasukan') }}" class="btn btn-info"><i class="fas fa-plus"></i> Pemasukan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <canvas id="myChart" style="min-height:30rem"></canvas>
        </div>
        <div class="card-footer">
            <form method="GET" action="{{ route('history.laporan') }}" class="">
                <div class="d-flex flex-row-reverse bd-highlight">
                    <div class="pl-md-2">
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

    <div class="card">
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
                    <div class="info-box mb-3 bg-warning h-100 shadow">
                        <span class="info-box-icon d-md-flex"><i class="fas fa-money-check-alt"></i></span>

                        <div class="info-box-content">
                            <p>Anda menyimpan <b>{{ moneyFormat($total_save) }}</b> dari total semua pemasukan dan pengeluaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 h-100">
                    <div class="info-box mb-3 bg-success h-100 shadow">
                        <span class="info-box-icon d-md-flex"><i class="fas fa-money-check"></i></span>

                        <div class="info-box-content">
                            <p>Anda menyimpan <b>{{ moneyFormat($bln_save) }}</b> dari total pemasukan dan pengeluaran bulan ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 pb-3">
            <div class="card h-100">
                <div class="card-header">
                    Pemasukan Anda Selama Bulan Ini
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="total_anggaran" style="width:100%">
                        <thead>
                            <tr>
                                <th>Bank</th>
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bln_uang_masuk as $opt)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($opt->nama, 50, $end='...')}}</td>
                                <td class="text-right">{{moneyFormat($opt->jumlah)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('bank.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 pb-3">
            <div class="card h-100">
                <div class="card-header">
                    Anggaran Anda Selama Bulan Ini
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="bln_anggaran" style="width:100%">
                        <thead>
                            <tr>
                                <th>Anggaran</th>
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bln_uang_anggaran as $opt)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($opt->nama, 50, $end='...')}}</td>
                                <td class="text-right">{{moneyFormat($opt->jumlah)}}</td>
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
        <div class="col-md-6 pb-3">
            <div class="card h-100">
                <div class="card-header">
                    History Terkini
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="dt_history" style="width:100%">
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
        <div class="col-md-6 pb-3">
            <div class="card h-100">
                <div class="card-header">
                    Plan Anda Selama Bulan Ini
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="dt_plan" style="width:100%">
                        <thead>
                            <tr>
                                <th>Anggaran</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $opt)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($opt->nama, 50, $end='...')}}</td>
                                <td class="text-right">{{moneyFormat($opt->total)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total uang yang harus Anda persiapkan untuk bulan ini</th>
                                <th class="text-right">{{moneyFormat($total_rencana)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('plan.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

