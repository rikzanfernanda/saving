$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

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

    $('[data-hapus]').each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().remove();
            let id = $(this).attr('data-hapus');
            let url = base_url + "/feedback/destroy/" + id;
            $.ajax({
                type: "GET",
                url: url
            }).done(function () {
                window.location.reload();
            });
        })
    });


    $('[data-edit]').each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            let id = $(this).attr('data-edit');
            let url = base_url + "/feedback/show/" + id;
            $.ajax({
                type: "GET",
                url: url,
            }).done(function (data) {
                let bt = JSON.parse(data);
                let form = $('#formEditFeedback');
                let url = form.attr('action') + '/' + id;

                form.find($('input[name="komentar"]')).val(bt.komentar);

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
