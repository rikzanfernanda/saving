@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h5 class="m-0">Bantuan dan Tanggapan</h5>
        </div>
        <div class="col-sm-6 text-right">
            <a href="" class="" data-toggle="modal" data-target="#modalCreateBantuan">Ajukan Pertanyaan</a>
        </div>
    </div>
    <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fas fa-inbox"></i></span>

        <div class="info-box-content">
            <p>Ajukan pertanyaan yang betul-betul Anda tidak tahu. Baca petunjuk terlebih dahulu sebelum mengajukan pertanyaan</p>
        </div>
    </div>

    @foreach ($bantuans as $bt)
    <div class="row">
        <div class="col-md-6">
            <div class="card bantuan">
                <div class="card-header">
                    <h5 class="card-title">{{ $bt->pertanyaan }}</h5>

                    <div class="card-tools mr-0">
                        <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modalEditBantuan" data-edit="{{ $bt->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-hapus="{{ $bt->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="products-list product-list-in-card text-right">
                        @foreach ($bt->tanggapan as $tg)
                        <li class="item">{{ $tg->tanggapan }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-6 d-none d-md-inline-block">
            <div class="card-header">
                <h5 class="card-title">{{ $bt->updated_at }}</h5>
            </div>

            <div class="card-body">
                <ul class="products-list product-list-in-card">
                    @foreach ($bt->tanggapan as $tg)
                    <li class="item  bg-transparent">{{ $tg->updated_at }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach

</div>

<!-- Modal create -->
<div class="modal fade" id="modalCreateBantuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mengajukan Pertanyaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('bantuan.store') }}" id="formCreateBantuan">
                    @csrf
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <input type="text" class="form-control" name="pertanyaan" required="required">
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
<div class="modal fade" id="modalEditBantuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('bantuan.update') }}" id="formEditBantuan">
                    @csrf
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <input type="text" class="form-control" name="pertanyaan" required="required">
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