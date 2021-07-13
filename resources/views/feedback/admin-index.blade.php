@extends('layout.admin')
@section('content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h5 class="">Feedback</h5>
        </div>
        <div class="col-sm-6 text-right">
            <a href="" class="" data-toggle="modal" data-target="#modalCreateFeedback"><i class="fas fa-plus"></i> Tambah Feedback</a>
        </div>
    </div>

    <div class="card">

        <div class="card-body">
            <table id="dt_feedback" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Komentar</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Total Feedback</th>
                        <th colspan="2">{{ $jumlah }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>

<!-- Modal create -->
<div class="modal fade" id="modalCreateFeedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Feedback Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('feedback.store') }}" id="formCreateFeedback">
                    @csrf
                    <div class="form-group">
                        <label>Nama User</label>
                        <input type="text" class="form-control" name="nama" required="required">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label>Komentar</label>
                        <input type="text" class="form-control" name="komentar" required="required">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-link text-decoration-none">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="modalEditFeedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('feedback.update') }}" id="formEditFeedback">
                    @csrf
                    <div class="form-group">
                        <label>Nama User</label>
                        <input type="text" class="form-control" name="nama">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label>Komentar</label>
                        <input type="text" class="form-control" name="komentar" required="required">
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