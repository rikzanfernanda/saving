@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Buat Pengeluaran</h5>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('bank.keluar') }}" id="formCreatePengeluaran">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah Uang</label>
                            <input type="text" class="form-control" name="jumlah[]" required="required" data-number="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bank" class="d-block">Bank</label>
                            <select name="bank[]" class="form-control" required="required">
                                <option value="" class="form-control">---</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Anggaran</label>
                            <select name="anggaran[]" class="form-control" required="required">
                                <option value="" class="form-control">---</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div id="newRow"></div>
                <a href="" class="" id="addRow">Tambah</a>
                <div class="text-right">
                    <button type="submit" class="btn btn-info">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection