@extends('layout.admin')
@section('content')

<div class="container-fluid">
    <div class="row mb-md-3 mb-2">
        <div class="col-sm-6">
            <h5>Bantuan dan Tanggapan</h5>
        </div>
        <div class="col-sm-6 text-md-right">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('bantuan.index') }}">Semua Bantuan</a>
                    <a class="dropdown-item" href="{{ route('bantuan.index', ['filter' => 'belum-ditanggapi']) }}">Belum Ditanggapi</a>
                </div>
            </div>
        </div>
    </div>

    <div id="bantuan-admin">
        <div class="row">
            @foreach ($bantuans as $bt)
            <div class="col-6 col-md-4 pb-2">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">{{ \Illuminate\Support\Str::limit($bt->pertanyaan, 100, $end='...') }}</h5>

                        <div class="card-tools mr-0">
                            <button type="button" class="btn btn-tool" data-hapus="{{ $bt->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        @php
                        $tg = count($bt->tanggapan);
                        @endphp
                        @if ($tg == 0)
                        <div class="info-box bg-warning">
                            <span class="info-box-icon d-md-flex d-none"><i class="fas fa-info-circle"></i></span>

                            <div class="info-box-content">
                                <p>Anda belum menanggapi</p>
                            </div>
                        </div>
                        @else
                        <div class="info-box bg-success">
                            <span class="info-box-icon d-md-flex d-none"><i class="fas fa-comment-alt"></i></span>

                            <div class="info-box-content">
                                <a href="" class="text-white" data-toggle="modal" data-target="#modalShowTanggapan-{{ $bt->id }}">Lihat</a>
                            </div>
                        </div>
                        @endif
                        <a href="" class="" data-toggle="modal" data-target="#modalCreateTanggapan" data-bantuan="{{$bt->id}}">Tanggapi</a>

                        <!-- Modal show tanggapan -->
                        <div class="modal fade" id="modalShowTanggapan-{{ $bt->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $bt->pertanyaan }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <ul class="products-list product-list-in-card pl-2 pr-2">
                                        @foreach ($bt->tanggapan as $opt)
                                        <li class="item">
                                            <div class="d-flex justify-content-between">
                                                <div>{{$opt->tanggapan}}</div>

                                                <div class="text-right text-small font-light">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="" class="btn btn-link text-decoration-none" data-toggle="modal" data-target="#modalEditTanggapan" data-tanggapan="{{$opt->id}}">Edit</a>
                                                            <a href="" class="btn btn-link text-decoration-none" data-hapustanggapan="{{$opt->id}}">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal create tanggapan -->
<div class="modal fade" id="modalCreateTanggapan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTanggapiTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tanggapan.store') }}" method="POST" id="formCreateTanggapan">
                @csrf
                <input type="hidden" name="id_bantuan" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggapan Anda</label>
                        <textarea name="tanggapan" rows="5" class="form-control" required="required"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit tanggapan -->
<div class="modal fade" id="modalEditTanggapan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tanggapan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tanggapan.update') }}" method="POST" id="formEditTanggapan">
                @csrf
                <input type="hidden" name="id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggapan</label>
                        <textarea id="inputTanggapan" name="tanggapan" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection