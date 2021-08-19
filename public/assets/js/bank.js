$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

    $.ajax({
        url: base_url + '/bank/chart',
        type: "GET"
    }).done(function (respon) {
        let data = JSON.parse(respon);

        const data_chart = {
            datasets: [{
                    type: 'bar',
                    label: 'Bank',
                    backgroundColor: 'rgb(0, 214, 111)',
                    borderColor: 'rgb(0, 214, 111)',
                    data: data
                }
            ]
        };
        const config = {
            data: data_chart,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        var myChart = new Chart(document.getElementById('myChart'), config);
    });

    $.ajax({
        url: base_url + '/bank/dt',
        type: "GET"
    }).done(function (data) {
        let bank = JSON.parse(data)
        for (var i = 0; i < bank.length; i++) {
            bank[i].tindakan = '<a href="' + base_url + '/bank/show/' + bank[i].id + '" class="text-green" data-edit="' + bank[i].id + '" data-toggle="modal" data-target="#modalEditBank"><i class="fas fa-edit"></i></a> <a href="' + base_url + '/bank/destroy/' + bank[i].id + '" class="ml-2 text-red" data-hapus="' + bank[i].id + '"><i class="fas fa-trash"></i></a>'
        }

        let table = $('#dt_bank').DataTable({
            "processing": true,
            "data": bank,
            "scrollX": true,
            "scrollCollapse": true,
            "columns": [
                {"data": "nama"},
                {"data": "saldo"},
                {"data": "tindakan"},
            ],
            "columnDefs": [
                {"width": "10%", "targets": 2},
                {className: "text-right", "targets": [1]}
            ]
        });

        $('[data-hapus]').each(function () {
            $(this).click(function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
                let id = $(this).attr('data-hapus');
                let url = $(this).attr('href');
                $.ajax({
                    type: "GET",
                    url: url
                });
            });
        });

        $('[data-edit]').each(function () {
            $(this).click(function (e) {
                e.preventDefault();
                let id = $(this).attr('data-edit');
                let url = $(this).attr('href');
                $.ajax({
                    type: "GET",
                    url: url,
                }).done(function (data) {
                    let bk = JSON.parse(data);
                    let form = $('#formEditBank');
                    let url = form.attr('action') + '/' + id;

                    form.find($('input[name="nama"]')).val(bk.nama);
                    form.find($('input[name="saldo"]')).val(bk.saldo);

                    //edit bank
                    form.submit(function (e) {
                        e.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: form.serialize()
                        }).done(function () {
                            window.location.reload();
                        });
                    });
                });
            })
        });


    });

    //create bank
    $('#formCreateBank').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize()
        }).done(function () {
            window.location.reload();
        });
    });

    // create pengeluaran
    $("#addRow").click(function (e) {
        e.preventDefault();
        var html = '';
        html += `
        <div class="mb-2" id="inputFormRow">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="jumlah">Jumlah Uang</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah[]" required="required">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bank">Bank</label>
                        <select id="bank" name="bank[]" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="anggaran">Anggaran</label>
                        <div class="d-flex">
                            <div class="input-group">
                                <select id="anggaran" name="anggaran[]" class="form-control">
                                </select>
                            </div>
                            <div class="">
                                <button id="removeRow" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        `;
        $('#newRow').append(html);

        let row = $('#newRow').children().last();
        $.ajax({
            url: base_url + '/bank/option',
            type: "GET"
        }).done(function (respon) {
            let data = JSON.parse(respon);
            row.find($('select[name="bank[]"]')).html('');
            $.each(data, function () {
                row.find($('select[name="bank[]"]')).append('<option value="' + this.id + '">' + this.nama + '</option>');
            });
        });
        $.ajax({
            url: base_url + '/anggaran/option',
            type: "GET"
        }).done(function (respon) {
            let data = JSON.parse(respon);
            row.find($('select[name="anggaran[]"]')).html('');
            $.each(data, function () {
                row.find($('select[name="anggaran[]"]')).append('<option value="' + this.id + '">' + this.nama + '</option>');
            });
        });
    });
    $(document).on('click', '#removeRow', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRow').remove();
    });

    // create pemasukan
    $("#addRowPemasukan").click(function (e) {
        e.preventDefault();
        var html = '';
        html += `
        <div class="mb-2" id="inputFormRowPemasukan">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jumlah">Jumlah Uang</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah[]" required="required">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank">Bank</label>
                        <div class="input-group">
                            <select id="bank" name="bank[]" class="form-control">
                                @foreach($banks as $opt)
                                <option value="{{$opt->id}}" class="form-control">{{$opt->nama}}</option>
                                @endforeach
                            </select>
                            <button id="removeRowPemasukan" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        $('#newRowPemasukan').append(html);

        let row = $('#newRowPemasukan').children().last();
        $.ajax({
            url: base_url + '/bank/option',
            type: "GET"
        }).done(function (respon) {
            let data = JSON.parse(respon);
            row.find($('select[name="bank[]"]')).html('');
            $.each(data, function () {
                row.find($('select[name="bank[]"]')).append('<option value="' + this.id + '">' + this.nama + '</option>');
            });
        });
        $.ajax({
            url: base_url + '/anggaran/option',
            type: "GET"
        }).done(function (respon) {
            let data = JSON.parse(respon);
            row.find($('select[name="anggaran[]"]')).html('');
            $.each(data, function () {
                row.find($('select[name="anggaran[]"]')).append('<option value="' + this.id + '">' + this.nama + '</option>');
            });
        });
    });
    $(document).on('click', '#removeRowPemasukan', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRowPemasukan').remove();
    });

    $('#dt_bln_masuk').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

});

