@extends('layout.user')
@section('content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h5 class="m-0">History Anda</h5>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table id="dt_history" class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Kegiatan</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>

</div>
@endsection