@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Bank dan Saldo Anda</h5>
    @if ($jumlah == 0)
    <div class="info-box mb-2 bg-danger">
        <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>

        <div class="info-box-content">
            <p>Anda belum memiliki bank apapun, buat terlebih dahulu dengan klik "Tambah Bank"</p>
        </div>
    </div>
    @else
    <div class="info-box mb-2 bg-success">
        <span class="info-box-icon d-md-flex"><i class="fas fa-money-bill-wave"></i></span>

        <div class="info-box-content">
            <p>Anda memiliki {{$jumlah}} bank dan total saldo Anda <b>{{ moneyFormat($total) }}</b></p>
        </div>
    </div>
    <div class="info-box mb-2 bg-info">
        <span class="info-box-icon d-md-flex"><i class="fas fa-inbox"></i></span>

        <div class="info-box-content">
            <p>Kendalikan pengeluraan Anda. Berhemat adalah cara terbaik untuk meraih tujuan keuangan</p>
        </div>
    </div>
    @endif

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
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="text-right">
                <a href="" class="" data-toggle="modal" data-target="#modalCreateBank"><i class="fas fa-plus"></i> Tambah Bank</a>
            </div>
        </div>
        <div class="card-body">
            <table id="dt_bank" class="table table-bordered table-hover" style="width:100%">
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
                    <div class="form-group">
                        <label>Anggaran</label>
                        <select name="anggaran" class="form-control">
                            @foreach($anggarans as $opt)
                            <option value="{{$opt->id}}" class="form-control text-truncate">{{ \Illuminate\Support\Str::limit($opt->nama, 30, $end='...')}}</option>
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
                        <button type="submit" class="btn btn-link text-decoration-none">Buat Bank</button>
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
                        <button type="submit" class="btn btn-link text-decoration-none">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection