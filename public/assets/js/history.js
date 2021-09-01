$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");
    const csrf = $("meta[name='csrf_token']").attr("content");

    $('#dt_history').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + '/history/dt',
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
            {"data": "kegiatan"},
            {"data": "tindakan"},
        ],
        "columnDefs": [
            {"width": "10%", "targets": 2},
        ]
    });

    $('#dt_history').on('click', '[data-restore]', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            success: function () {
                alert('Berhasil');
            }
        }).done(function (data) {
            $('#dt_history').DataTable().ajax.reload();
        });
    });
    
});
