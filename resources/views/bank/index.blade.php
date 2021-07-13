@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h5 class="m-0">Bank dan Saldo Anda</h5>
        </div>
        <div class="col-sm-6 text-right">
            <a href="" class="" data-toggle="modal" data-target="#modalCreateBank"><i class="fas fa-plus"></i> Tambah Bank</a>
        </div>
    </div>
    @if ($jumlah == 0)
    <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>

        <div class="info-box-content">
            <p>Anda belum memiliki bank apapun, buat terlebih dahulu dengan klik "Tambah Bank"</p>
        </div>
    </div>
    @endif

    <div class="card mb-4">

        <div class="card-body">
            <table id="dt_bank" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bank</th>
                        <th>Saldo</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="2">Total Saldo Anda</th>
                        <th colspan="2">{{ moneyFormat($total) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    <div class="row mb-3">
        <div class="col-sm-6">
            <h5 class="mb-3">Buat Pemasukan</h5>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('bank.masuk') }}" id="formCreatePemasukan">
                        @csrf
                        <input type="hidden" name="route" value="bank">
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
        <div class="col-sm-6">
            <h5 class="mb-3">Buat Pengeluaran</h5>
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('bank.keluar') }}" id="formCreatePengeluaran">
                        @csrf
                        <input type="hidden" name="route" value="bank">
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

@endsection