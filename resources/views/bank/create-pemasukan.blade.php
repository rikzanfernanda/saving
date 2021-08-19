@extends('layout.user')
@section('content')

<div class="container-fluid">
    <h5 class="mb-3">Buat Pemasukan</h5>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('bank.masuk') }}" id="formCreatePemasukan">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jumlah Uang</label>
                            <input type="number" class="form-control" name="jumlah[]" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bank</label>
                            <select name="bank[]" class="form-control" required="required">
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