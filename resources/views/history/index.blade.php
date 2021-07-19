@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">History Anda</h5>
    <div class="info-box mb-2 bg-info">
        <span class="info-box-icon d-md-flex"><i class="fas fa-inbox"></i></span>

        <div class="info-box-content">
            <p>
                Tombol <i class="fas fa-trash-restore text-red"></i> (restore) tujuannya adalah ketika
                Anda telah melakukan input pamsukan/pengeluaran dan Anda ingin mengembalikannya. Ini akan 
                mengembalikan saldo dibank Anda seperti semula
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="dt_history" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>

</div>
@endsection