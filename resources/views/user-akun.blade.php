@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-md-6">
            
            <div class="card-header border-bottom-0">
                <h5 class="card-title">Akun</h5>

                <div class="card-tools mr-0">
                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modalEditAkun" data-edit="{{ $akun->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <a href="{{ route('user.destroy', $akun->id)}}" class="btn btn-tool" onclick="return confirm('Akun Anda akan dihapus dan Anda akan keluar dari aplikasi')"><i class="fas fa-trash"></i></a>
                </div>
            </div>
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" value="{{ $akun->nama }}" disabled="disabled">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $akun->email }}" disabled="disabled">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <input type="text" class="form-control" name="pekerjaan" value="{{ $akun->pekerjaan }}" disabled="disabled">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" value="{{ $akun->alamat }}" disabled="disabled">
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Registrasi</label>
                                <input type="text" class="form-control" value="{{ $akun->created_at }}" disabled="disabled">
                                <small class="form-text text-muted"></small>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-sm-6">

        </div>
    </div>



</div>

<!-- Modal edit -->
<div class="modal fade" id="modalEditAkun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.update', $akun->id) }}" id="formEditakun">
                    @csrf
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" value="{{ $akun->nama }}">
                        @error('nama')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $akun->email }}">
                        @error('email')<small class="form-text text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" value="{{ $akun->pekerjaan }}">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="{{ $akun->alamat }}">
                        <small class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        *Kosongkan jika password tidak ingin diubah
                        <input type="password" name="password" class="form-control">
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