$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");


    $.ajax({
        url: base_url + '/user/dt',
        type: "GET"
    }).done(function (respon) {
        let data = JSON.parse(respon)
        for (var i = 0; i < data.length; i++) {
            data[i].tindakan = '<a href="' + base_url + '/user/show/' + data[i].id + '" class="text-green" data-edit="' + data[i].id + '" data-toggle="modal" data-target="#modalEditUser"><i class="fas fa-edit"></i></a> <a href="' + base_url + '/user/destroy/' + data[i].id + '" class="ml-2 text-red" data-hapus="' + data[i].id + '"><i class="fas fa-trash"></i></a>'
        }

        let table = $('#dt_user').DataTable({
            "processing": true,
            "data": data,
            "scrollX": true,
            "scrollCollapse": true,
            "order": [[2, "desc"]],
            "columns": [
                {"data": "nama"},
                {"data": "email"},
                {"data": "created_at"},
                {"data": "tindakan"},
            ],
            "columnDefs": [
                {"width": "10%", "targets": 3}
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
                    let form = $('#formEditUser');
                    let url = form.attr('action') + '/' + id;
                    
                    form.find($('input[name="nama"]')).val(bk.nama);
                    form.find($('input[name="email"]')).val(bk.email);
                    form.find($('input[name="pekerjaan"]')).val(bk.pekerjaan);
                    form.find($('input[name="alamat"]')).val(bk.alamat);

                    //edit user
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

    //create user
    $('#formCreateUser').submit(function (e) {
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

