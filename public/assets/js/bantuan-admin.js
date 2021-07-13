$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

    $('[data-bantuan]').each(function () {
        let data_bt = $(this).attr('data-bantuan');
        $(this).on('click', function () {
            $.ajax({
                url: base_url + '/bantuan/show/' + data_bt,
                type: "GET"
            }).done(function (data) {
                data = JSON.parse(data);
                $('#modalTanggapiTitle').html(data.pertanyaan);
                $('input[name="id_bantuan"]').val(data.id);
            });
        });
    });

    $('[data-hapus]').each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().remove();
            let id = $(this).attr('data-hapus');
            let url = base_url + "/bantuan/destroy/" + id;
            $.ajax({
                type: "GET",
                url: url
            }).done(function () {
                window.location.reload();
            });
        })
    });

    //create tanggapan
    $('#formCreateTanggapan').submit(function (e) {
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

    //edit tanggapan
    $('[data-tanggapan]').each(function () {
        let data_tg = $(this).attr('data-tanggapan');

        $(this).on('click', function () {
            $.ajax({
                url: base_url + '/tanggapan/show/' + data_tg,
                type: "GET"
            }).done(function (data) {
                data = JSON.parse(data);
                $('input[name="id"]').val(data.id);
                $('#inputTanggapan').html(data.tanggapan);
            });
        });
    });

    $('#formEditTanggapan').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url + '/' + $('input[name="id"]').val(),
            data: form.serialize(), // serializes the form's elements.
        }).done(function () {
            window.location.reload();
        });
    });

    //hapus tanggapan
    $('[data-hapustanggapan]').each(function () {
        let data_tg = $(this).attr('data-hapustanggapan');

        $(this).on('click', function (e) {
            $(this).parent().parent().parent().parent().remove();
            e.preventDefault();
            $.ajax({
                url: base_url + '/tanggapan/destroy/' + data_tg,
                type: "GET"
            }).done(function () {
                window.location.reload();
            });
        });
    });


});
