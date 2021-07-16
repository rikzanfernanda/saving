@extends('layout.admin')
@section('content')

<div class="container-fluid">
    @if ($bantuans > 0)
    <div class="info-box mb-2 bg-warning">
        <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>

        <div class="info-box-content">
            <p class="mb-1">Anda memiliki {{$bantuans}} pertanyaan user yang belum Anda tanggapi</p>
            <a href="{{ route('bantuan.index') }}" class="text-white">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endif
    
    <h5 class="mb-3">Grafik User Saving</h5>
    <div class="card mb-4">
        <div class="card-body">
            <canvas id="myChart" style="min-height:30rem"></canvas>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="mb-3">User Registrasi Bulan Ini</h5>
            <div class="card">
                <div class="card-body">
                    <table id="dt_user" class="table table-hover" id="total_anggaran" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $opt)
                            <tr>
                                <td>{{$opt->nama}}</td>
                                <td>{{$opt->alamat}}</td>
                                <td>{{$opt->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('user.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h5 class="mb-3">Feedback</h5>
            <div class="card">
                <div class="card-body">
                    <table id="dt_feedback" class="table table-hover" id="total_anggaran" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Komentar</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $opt)
                            <tr>
                                <td>{{$opt->nama}}</td>
                                <td>{{ \Illuminate\Support\Str::limit($opt->komentar, 50, $end='...')}}</td>
                                <td>{{$opt->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('feedback.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

