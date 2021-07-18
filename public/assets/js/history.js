$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

    $.ajax({
        url: base_url + '/history/dt',
        type: "GET"
    }).done(function (data) {
        let admins = JSON.parse(data);
        for (var i = 0; i < admins.length; i++) {
            admins[i].tindakan = '<a href="' + base_url + '/history/restore/' + admins[i].id + '" class="ml-2 text-red" data-restore="' + admins[i].id + '"><i class="fas fa-trash-restore"></i></a>';
        }
        $('#dt_history').DataTable({
            "data": admins,
            "scrollX": true,
            "scrollCollapse": true,
            "columns": [
                {"data": "kegiatan"},
                {"data": "created_at"},
                {"data": "tindakan"}
            ],
            "order": [[1, "desc"]]
        });

        $('[data-restore]').each(function () {
            $(this).click(function (e) {
                e.preventDefault();
                let id = $(this).attr('data-restore');
                let url = $(this).attr('href');
                $.ajax({
                    type: "GET",
                    url: url
                }).done(function () {
                    window.location.reload();
                });
            });
        });
    });
});
