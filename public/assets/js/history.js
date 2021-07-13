$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

    $.ajax({
        url: base_url + '/history/dt',
        type: "GET"
    }).done(function (data) {
        let admins = JSON.parse(data)
        $('#dt_history').DataTable({
            "data": admins,
            "scrollX": true,
            "scrollCollapse": true,
            "columns": [
                {"data": "kegiatan"},
                {"data": "kategori"},
                {"data": "jumlah"},
                {"data": "created_at"},
            ],
            "order": [[3, "desc"]]
        });
    });
});
