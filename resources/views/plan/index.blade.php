@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3 mx-3 mx-md-0">Rencana Anggaran Anda dalam Satu Bulan</h5>

    <div class="info-box mb-3 bg-success shadow-sm">
        <span class="info-box-icon d-none d-md-flex"><i class="fas fa-inbox"></i></span>

        <div class="info-box-content">
            <p>
                "Memiliki tujuan tanpa perencanaan seperti ingin melakukan perjalanan ke tujuan baru tanpa peta." <br>
                Buatlah rencana anggaran Anda untuk satu bulan kedepan!
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-4">
                    <a href="{{route('plan.create')}}" class=""><i class="fas fa-plus"></i> Plan</a>
                </div>
                <div class="col-8">
                    <form method="GET" action="{{ route('plan.index') }}">
                        <div class="d-flex flex-row-reverse">
                            <div class="">
                                <button type="submit" class="btn btn-info text-decoration-none">Cek</button>
                            </div>

                            <div class="form-group px-2">
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

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="min-width: 6rem"></th>
                        <th style="min-width: 8rem"></th>
                        <th style="min-width: 10rem"></th>
                        <th class="text-right">Total Rencana</th>
                        <th class="text-right">Realisasi</th>
                        <th class="text-right">Selisih</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $value)
                    <tr class="" id="tr-{{ $value->id }}">
                        <td>{{ \Illuminate\Support\Str::limit($value->nama, 30, $end='...')}}</td>
                        <td class="text-right">{{ moneyFormat($value->jumlah) }}</td>
                        <td>{{ $value->frekuensi }} x {{ $value->satuan }}</td>
                        <td class="text-right">{{ moneyFormat($value->total) }}</td>
                        <td class="text-right">{{ moneyFormat($value->realisasi) }}</td>
                        <td class="text-right">{{ moneyFormat($value->total - $value->realisasi) }}</td>
                        <td>
                            <a href="" class="text-green mx-1" data-edit="{{ $value->id }}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('plan.destroy', $value->id)}}" class="text-red mx-1" data-hapus="{{ $value->id }}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <tr class="row-field d-none" id="row-{{ $value->id }}">
                        <td>
                            <select name="id_anggaran" class="form-control">
                                @foreach($anggarans as $opt)
                                @if ($opt->id == $value->id_anggaran)
                                <option value="{{$opt->id}}" class="form-control text-truncate" selected="selected">{{ \Illuminate\Support\Str::limit($opt->nama, 30, $end='...')}}</option>
                                @else
                                <option value="{{$opt->id}}" class="form-control text-truncate">{{ \Illuminate\Support\Str::limit($opt->nama, 30, $end='...')}}</option>
                                @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text" name="jumlah" class="form-control" value="{{ $value->jumlah }}" required="required" data-number="true">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="input-group">
                                    <input type="number" name="frekuensi" class="form-control" value="{{ $value->frekuensi }}" required="required">
                                    <div class="input-group-append">
                                        <div class="input-group-text form-control">X</div>
                                    </div>
                                </div>
                                <div class="ml-2 w-100">
                                    <select name="satuan" class="form-control" required="required">
                                        <option value="Sehari" class="form-control" @if($value->satuan == "Sehari") selected="selected" @endif>Sehari</option>
                                        <option value="Seminggu" class="form-control" @if($value->satuan == "Seminggu") selected="selected" @endif>Seminggu</option>
                                        <option value="Sebulan" class="form-control" @if($value->satuan == "Sebulan") selected="selected" @endif>Sebulan</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="id" value="{{ $value->id }}">
                            <input type="hidden" name="bulan" value="{{ $bulan_ini }}">
                            <input type="hidden" name="tahun" value="{{ $tahun_ini }}">
                            <input type="submit" value="Simpan" name="simpan" class="btn btn-info">
                        </td>
                        <td>
                            <a href="" class="btn btn-danger" data-cancel="{{ $value->id }}">Cancel</a>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-right">{{ moneyFormat($total_rencana) }}</th>
                        <th class="text-right">{{ moneyFormat($total_realisasi) }}</th>
                        <th class="text-right">{{ moneyFormat($total_rencana - $total_realisasi) }}</th>
                        <th></th>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Pengeluaran Anda dalam Satu Bulan
        </div>
        <div class="card-body">
            <table id="dt_bln_anggaran" class="table table-hover" style="width:100%">
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
@endsection