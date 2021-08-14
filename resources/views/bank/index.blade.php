@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Bank dan Saldo Anda</h5>
    @if ($jumlah == 0)
    <div class="info-box mb-3 bg-danger shadow">
        <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>

        <div class="info-box-content">
            <p>Anda belum memiliki bank apapun, buat terlebih dahulu dengan klik "Tambah Bank"</p>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-6">
            <div class="info-box mb-2 bg-success shadow">
                <span class="info-box-icon d-md-flex"><i class="fas fa-money-bill-wave"></i></span>

                <div class="info-box-content">
                    <p>Anda memiliki {{$jumlah}} bank dan total saldo Anda <b>{{ moneyFormat($total) }}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box bg-info shadow">
                <span class="info-box-icon d-md-flex"><i class="fas fa-inbox"></i></span>

                <div class="info-box-content">
                    <p>Kendalikan pengeluraan Anda. Berhemat adalah cara terbaik untuk meraih tujuan keuangan</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="text-right">
                <a href="" class="btn btn-outline-info" data-toggle="modal" data-target="#modalCreatePengeluaran"><i class="fas fa-plus"></i> Pengeluaran</a>
                <a href="" class="btn btn-info ml-md-2" data-toggle="modal" data-target="#modalCreatePemasukan"><i class="fas fa-plus"></i> Pemasukan</a>
            </div>
        </div>
        <div class="card-body">
            <canvas id="myChart" style="min-height:30rem"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="text-right">
                <a href="" class="btn btn-info" data-toggle="modal" data-target="#modalCreateBank"><i class="fas fa-plus"></i> Bank</a>
            </div>
        </div>
        <div class="card-body">
            <table id="dt_bank" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Bank</th>
                        <th class="text-right">Saldo</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <div class="card">
        <div class="card-header">
            Pemasukan Anda perbulan
            <form method="GET" action="{{ route('bank.index') }}" class="mt-2 d-flex flex-row-reverse">
                <div class="bd-highlight">
                    <button type="submit" class="btn btn-info text-decoration-none">Cek</button>
                </div>
                <div class="form-group mx-2">
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
            </form>
        </div>
        <div class="card-body">
            <table id="dt_bln_masuk" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Bank</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bln_bank as $opt)
                    <tr>
                        <td>{{ \Illuminate\Support\Str::limit($opt->nama, 50, $end='...') }}</td>
                        <td class="text-right">{{ moneyFormat($opt->jumlah) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th class="text-right">{{ moneyFormat($bln_masuk)}}</th>
                    </tr>
                </tfoot>
            </table>
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
                    <input type="hidden" name="route" value="bank">
                    <div class="form-group">
                        <label>Jumlah Uang</label>
                        <input type="number" class="form-control" name="jumlah" required="required">
                    </div>
                    <div class="form-group">
                        <label>Bank</label>
                        <select name="bank" class="form-control">
                            @foreach($banks as $opt)
                            <option value="{{$opt->id}}" class="form-control">{{$opt->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">Buat</button>
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
                    <input type="hidden" name="route" value="bank">
                    <div class="form-group">
                        <label>Jumlah Uang</label>
                        <input type="number" class="form-control" name="jumlah[]" required="required">
                    </div>
                    <div class="form-group">
                        <label>Bank</label>
                        <select name="bank[]" class="form-control">
                            @foreach($banks as $opt)
                            <option value="{{$opt->id}}" class="form-control">{{$opt->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Anggaran</label>
                        <select name="anggaran[]" class="form-control">
                            @foreach($anggarans as $opt)
                            <option value="{{$opt->id}}" class="form-control text-truncate">{{ \Illuminate\Support\Str::limit($opt->nama, 30, $end='...')}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="newRow"></div>
                    <a href="" class="" id="addRow">Tambah</a>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal create -->
<div class="modal fade" id="modalCreateBank" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Bank Baru Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Note: nama bank adalah nama tempat dimana Anda menyimpan uang.
                <small class="font-italic">Contoh: BRI, DANA, ShopeePay, Dompet, Brangkas/Lemari</small>
                <form method="POST" action="{{ route('bank.store') }}" id="formCreateBank">
                    @csrf
                    <div class="form-group">
                        <label>Nama Bank</label>
                        <input type="text" class="form-control" name="nama" required="required">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label>Saldo</label>
                        <input type="number" class="form-control" name="saldo" required="required">
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">Buat Bank</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="modalEditBank" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('bank.update') }}" id="formEditBank">
                    @csrf
                    <div class="form-group">
                        <label>Nama Bank</label>
                        <input type="text" class="form-control" name="nama" required="required">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label>Saldo</label>
                        <input type="number" class="form-control" name="saldo" required="required">
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection