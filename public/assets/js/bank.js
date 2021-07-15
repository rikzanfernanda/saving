$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");


    $.ajax({
        url: base_url + '/bank/dt',
        type: "GET"
    }).done(function (data) {
        let bank = JSON.parse(data)
        let no = 1;
        for (var i = 0; i < bank.length; i++) {
            bank[i].tindakan = '<a href="' + base_url + '/bank/show/' + bank[i].id + '" class="text-green" data-edit="' + bank[i].id + '" data-toggle="modal" data-target="#modalEditBank"><i class="fas fa-edit"></i></a> <a href="' + base_url + '/bank/destroy/' + bank[i].id + '" class="ml-2 text-red" data-hapus="' + bank[i].id + '"><i class="fas fa-trash"></i></a>'
            bank[i].no = no;
            no++;
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


});

