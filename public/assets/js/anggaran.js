$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");


    $.ajax({
        url: base_url + '/anggaran/dt',
        type: "GET"
    }).done(function (data) {
        let dt = JSON.parse(data)
        let no = 1;
        for (var i = 0; i < dt.length; i++) {
            dt[i].tindakan = '<a href="' + base_url + '/anggaran/show/' + dt[i].id + '" class="text-green" data-edit="' + dt[i].id + '" data-toggle="modal" data-target="#modalEditAnggaran"><i class="fas fa-edit"></i></a> <a href="' + base_url + '/anggaran/destroy/' + dt[i].id + '" class="ml-2 text-red" data-hapus="' + dt[i].id + '"><i class="fas fa-trash"></i></a>'
            dt[i].no = no;
            no++;
        }

        let table = $('#dt_anggaran').DataTable({
            "processing": true,
            "data": dt,
            "scrollX": true,
            "scrollCollapse": true,
            "columns": [
                {"data": "no"},
                {"data": "nama"},
                {"data": "tindakan"},
            ],
            "columnDefs": [
                {"width": "5%", "targets": 0},
                {"width": "10%", "targets": 2}
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
                })
            })
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
                    let form = $('#formEditAnggaran');
                    let url = form.attr('action') + '/' + id;

                    form.find($('input[name="nama"]')).val(bk.nama);

                    //edit anggaran
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

    //create anggaran
    $('#formCreateAnggaran').submit(function (e) {
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
    
    $("#addRow").click(function (e) {
        e.preventDefault();
        var html = '';
        html += `<div class="form-group" id="inputFormRow">`;
        html += `<label>Nama Anggaran</label>`;
        html += `<div class="input-group">`;
        html += `<input type="text" class="form-control" name="nama[]" required="required">`;
        html += `<div><button id="removeRow" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button></div>`;
        html += `</div>`;
        html += `</div>`;
        $('#newRow').append(html);
    });
    $(document).on('click', '#removeRow', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRow').remove();
    });

    // semua
    $.ajax({
        url: base_url + '/anggaran/laporan',
        type: "GET"
    }).done(function (data) {
        let dt = JSON.parse(data)
        $('#dt_uang_anggaran').DataTable({
            "processing": true,
            "scrollY": 400,
            "scrollX": true,
            "paging": false,
            "scrollCollapse": true,
            "data": dt,
            "dom": 'lrtip',
            "columns": [
                {"data": "nama"},
                {"data": "jumlah"},
            ],
            "columnDefs": [
                { className: "text-right", "targets": [ 1 ] }
            ]
        });
    });

    $('#dt_bln_uang_anggaran').DataTable({
        "processing": true,
        "scrollY": 400,
        "scrollX": true,
        "paging": false,
        "scrollCollapse": true,
        "dom": 'lrtip'
    });

});

