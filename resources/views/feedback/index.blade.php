@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h5 class="m-0">Feedback</h5>
        </div>
        <div class="col-sm-6">
            
        </div>
    </div>
    <p>
        Feedback Anda sangat berarti untuk pengembangan aplikasi saving, kritik dan masukan Anda melalui feedback ini akan kami terima dengan baik demi kemajuan aplikasi saving.
        Kami sebagai pengembang aplikasi saving meminta Anda memberikan feedback Anda, apa saja fitur yang harus ditambahkan ataupun fitur mana yang harus diperbaiki.
        Anda juga bisa memberikan feedback kepada kami berisi kesan dan pesan Anda selama menggunakan aplikasi saving ini.
        Kami sebagai pengembang aplikasi juga berterima kasih kepada Anda yang sudah menggunakan aplikasi saving ini.
    </p>
    
    <div class="text-right mb-4">
        <a href="" class="" data-toggle="modal" data-target="#modalCreateFeedback">Kirim Feedback</a>
    </div>
    @foreach($feedbacks as $feedback)
    <div class="card feedback">
        <div class="card-header">
            <div class="card-tools mr-0">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modalEditFeedback" data-edit="{{ $feedback->id }}">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-tool" data-hapus="{{ $feedback->id }}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <p>{{ $feedback->komentar }}</p>
        </div>
    </div>
    @endforeach

</div>

<!-- Modal create -->
<div class="modal fade" id="modalCreateFeedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Feedback untuk Developer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('feedback.store') }}" id="formCreateFeedback">
                    @csrf
                    <div class="form-group">
                        <label>Feedback Anda</label>
                        <textarea name="komentar" class="form-control" rows="5" required="required"></textarea>
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
                        <label>Feedback Anda</label>
                        <textarea name="komentar" class="form-control" rows="5" required="required"></textarea>
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