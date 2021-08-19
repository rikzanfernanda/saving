@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Buat Plan Baru</h5>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{route('plan.store')}}">
                @csrf
                <div class="row justify-content-end">
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label class="">Bulan</label>
                            <select name="bulan" class="form-control">
                                @foreach($bulan as $key => $opt)
                                <option value="{{$key+1}}" class="form-control text-truncate">{{ $opt}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label class="">Tahun</label>
                            <select name="tahun" class="form-control">
                                @foreach($tahun as $opt)
                                <option value="{{$opt}}" class="form-control text-truncate">{{ $opt}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2" id="row1">
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label class="">Anggaran</label>
                            <select name="id_anggaran[]" class="form-control" required="required">
                                <option value="">---</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label class="">Jumlah</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text form-control">Rp.</div>
                                </div>
                                <input type="number" name="jumlah[]" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label class="">Frekuensi</label>
                            <div class="d-flex">
                                <div class="input-group">
                                    <input type="number" name="frekuensi[]" class="form-control" required="required">
                                    <div class="input-group-append">
                                        <div class="input-group-text form-control">X</div>
                                    </div>
                                </div>
                                <div class="ml-2 w-100">
                                    <select name="satuan[]" class="form-control" required="required">
                                        <option value="" class="form-control"></option>
                                        <option value="Sehari" class="form-control">Sehari</option>
                                        <option value="Seminggu" class="form-control">Seminggu</option>
                                        <option value="Sebulan" class="form-control">Sebulan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label class="">Total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text form-control">Rp.</div>
                                </div>
                                <input type="number" name="total[]" class="form-control" readonly="readonly">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="newRow"></div>
                <a href="" class="" id="addRow">Tambah</a>
                <div class="text-right">
                    <a href="{{route('plan.index')}}" class="btn btn-outline-info">Cancel</a>
                    <button type="submit" class="btn btn-info ml-md-2">Buat</button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection