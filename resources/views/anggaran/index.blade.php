@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Anggaran Anda</h5>
    <div class="info-box mb-2 bg-info">
        <span class="info-box-icon"><i class="fas fa-inbox"></i></span>

        <div class="info-box-content">
            <p>
                Buat beberapa anggaran yang sesuai agar pengeluaran Anda lebih terkontrol
                <br>
                <b>Anda memiliki {{$jumlah}} anggaran</b>
            </p>
        </div>
    </div>

    @if ($jumlah == 0)
    <div class="info-box mb-2 bg-danger">
        <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>

        <div class="info-box-content">
            <p>Anda belum memiliki anggaran apapun, buat terlebih dahulu dengan klik "Tambah Anggaran"</p>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="text-right">
                <a href="" class="" data-toggle="modal" data-target="#modalCreateAnggaran"><i class="fas fa-plus"></i> Tambah Anggaran</a>
            </div>
        </div>
        <div class="card-body">
            <table id="dt_anggaran" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggaran</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Semua Anggaran Anda
                </div>
                <div class="card-body">
                    <table id="dt_uang_anggaran" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Anggaran</th>
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-right">{{ moneyFormat($total_keluar)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    Anggaran Anda perbulan
                    <form method="GET" action="{{ route('anggaran.index') }}" class="mt-2 d-flex flex-row-reverse">
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
                    <table id="dt_bln_uang_anggaran" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Anggaran</th>
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bln_anggaran as $opt)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($opt->nama, 50, $end='...') }}</td>
                                <td class="text-right">{{ moneyFormat($opt->jumlah) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-right">{{ moneyFormat($bln_keluar)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal create -->
<div class="modal fade" id="modalCreateAnggaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Anggaran Baru Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('anggaran.store') }}" id="formCreateAnggaran">
                    @csrf
                    <div class="form-group">
                        <label>Nama Anggaran</label>
                        <input type="text" class="form-control" name="nama[]" required="required">
                    </div>

                    <div id="newRow"></div>
                    <a href="" class="" id="addRow">Tambah</a>
                    <div class="text-right">
                        <button type="submit" class="btn btn-link text-decoration-none">Buat Anggaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="modalEditAnggaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('anggaran.update') }}" id="formEditAnggaran">
                    @csrf
                    <div class="form-group">
                        <label>Nama Anggaran</label>
                        <input type="text" class="form-control" name="nama" required="required">
                        <small class="form-text text-muted"></small>
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