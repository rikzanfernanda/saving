@extends('layout.admin')
@section('content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h5 class="m-0">User Saving</h5>
        </div>
        <div class="col-sm-6 text-right">
            <a href="" class="" data-toggle="modal" data-target="#modalCreateUser"><i class="fas fa-plus"></i> Tambah User</a>
        </div>
    </div>

    <div class="card">

        <div class="card-body">
            <table id="dt_user" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Registrasi</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="2">Total User</th>
                        <th colspan="2">{{$jumlah}} orang</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</div>

<!-- Modal create -->
<div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat User Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.store') }}" id="formCreateUser">
                    @csrf
                    <input type="hidden" name="id_role" value="3">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" required="required">
                        @error('nama')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" required="required">
                        @error('email')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat">

                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required="required">
                        @error('password')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-link text-decoration-none">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.update') }}" id="formEditUser">
                    @csrf
                    <input type="hidden" name="id_role" value="3">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" required="required">
                        @error('nama')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" required="required">
                        @error('email')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat">

                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                        @error('password')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-link text-decoration-none">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection