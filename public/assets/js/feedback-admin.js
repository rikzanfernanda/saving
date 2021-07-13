$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");


    $.ajax({
        url: base_url + '/feedback/dt',
        type: "GET"
    }).done(function (data) {
        let dt = JSON.parse(data)
        for (var i = 0; i < dt.length; i++) {
            dt[i].tindakan = '<a href="' + base_url + '/feedback/show/' + dt[i].id + '" class="text-green" data-edit="' + dt[i].id + '" data-toggle="modal" data-target="#modalEditFeedback"><i class="fas fa-edit"></i></a> <a href="' + base_url + '/feedback/destroy/' + dt[i].id + '" class="ml-2 text-red" data-hapus="' + dt[i].id + '"><i class="fas fa-trash"></i></a>'
        }

        let table = $('#dt_feedback').DataTable({
            "processing": true,
            "data": dt,
            "scrollX": true,
            "scrollCollapse": true,
            "columns": [
                {"data": "nama"},
                {"data": "komentar"},
                {"data": "tindakan"},
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
                    let form = $('#formEditFeedback');
                    let url = form.attr('action') + '/' + id;

                    form.find($('input[name="nama"]')).val(bk.nama);
                    form.find($('input[name="komentar"]')).val(bk.komentar);

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

    //create feedback
    $('#formCreateFeedback').submit(function (e) {
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

});

