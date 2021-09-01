$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");
    const csrf = $("meta[name='csrf_token']").attr("content");

    $('#dt_anggaran').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + '/anggaran/dt',
            "dataType": "json",
            "type": "POST",
            "data": {
                "_token": csrf
            }
        },
        "scrollX": true,
        "scrollCollapse": true,
        "columns": [
            {"data": "created_at"},
            {"data": "nama"},
            {"data": "total"},
            {"data": "tindakan"}
        ],
        "columnDefs": [
            {"width": "15%", "targets": 0},
            {"width": "20%", "targets": 2},
            {"width": "10%", "targets": 3}
        ]
    });

    //klik edit anggaran
    $('#dt_anggaran').on('click', '[data-edit]', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-edit');
        let url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
        }).done(function (data) {
            let bk = JSON.parse(data);
            let form = $('#formEditAnggaran');

            form.find($('input[name="id"]')).val(bk.id);
            form.find($('input[name="nama"]')).val(bk.nama);
        });
    });
    
    //edit anggaran
    $('#formEditAnggaran').submit(function (e) {
        e.preventDefault();
        let url = $(this).attr('action') + '/' + $(this).find($('input[name="id"]')).val();
        $('button[type=submit]').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            success: function () {
                toastr.success('Berhasil');
            },
            error: function () {
                toastr.error('Gagal');
                window.location.reload();
            }
        }).done(function () {
            $("#formEditAnggaran")[0].reset();
            $('button[type=submit]').prop('disabled', false);
            $('#dt_anggaran').DataTable().ajax.reload();
            $('#modalEditAnggaran').modal('hide');
        });
    });

    //hapus anggaran
    $('#dt_anggaran').on('click', '[data-hapus]', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            success: function () {
                toastr.success('Berhasil');
            },
            error: function () {
                toastr.error('Gagal');
                window.location.reload();
            }
        }).done(function () {
            $('#dt_anggaran').DataTable().ajax.reload();
        });
    });

    //create anggaran
    $('#formCreateAnggaran').submit(function (e) {
        e.preventDefault();
        $('button[type=submit]').prop('disabled', true);

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function () {
                toastr.success('Berhasil');
            },
            error: function () {
                toastr.error('Gagal');
                window.location.reload();
            }
        }).done(function () {
            $("#formCreateAnggaran")[0].reset();
            $('button[type=submit]').prop('disabled', false);
            $('#dt_anggaran').DataTable().ajax.reload();
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

    $('#dt_bln_uang_anggaran').DataTable({
        "processing": true,
        "paging": false,
        "scrollCollapse": true,
        "dom": 'lrtip'
    });

});

