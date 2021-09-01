$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");
    const csrf = $("meta[name='csrf_token']").attr("content");

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
                number = number_string.replace(/,/g, ''),
                split = number.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "," : "";
            rupiah += separator + ribuan.join(",");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
    }

    function getNumber(element) {
        var val = element.val() || element.html();
        val = val.replace(/[^,\d]/g, "").toString();
        val = val.split(',').join('');
        return isNaN(val) || val.length < 1 ? 0 : parseInt(val);
    }

    $.ajax({
        url: base_url + '/bank/chart',
        type: "GET"
    }).done(function (respon) {
        let data = JSON.parse(respon);

        const data_chart = {
            datasets: [{
                    type: 'bar',
                    label: 'Bank',
                    backgroundColor: 'rgb(0, 214, 111)',
                    borderColor: 'rgb(0, 214, 111)',
                    data: data
                }
            ]
        };
        const config = {
            data: data_chart,
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        var myChart = new Chart(document.getElementById('myChart'), config);
    });

    $('#dt_bank').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url + '/bank/dt',
            "dataType": "json",
            "type": "POST",
            "data": {
                "_token": csrf
            }
        },
        "scrollX": true,
        "scrollCollapse": true,
        "columns": [
            {"data": "nama"},
            {"data": "saldo"},
            {"data": "tindakan"},
        ],
        "columnDefs": [
            {"width": "10%", "targets": 2},
            {className: "text-right", "targets": [1]}
        ]
    });

    // format number row 1
    $('[data-number="true"]').each(function () {
        $(this).keyup(function () {
            $(this).val(formatRupiah($(this).val(), "Rp. "));
        });
    });

    //klik edit bank
    $('#dt_bank').on('click', '[data-edit]', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
        }).done(function (data) {
            let bk = JSON.parse(data);
            let form = $('#formEditBank');

            form.find($('input[name="id"]')).val(bk.id);
            form.find($('input[name="nama"]')).val(bk.nama);
            form.find($('input[name="saldo"]')).val(bk.saldo);
        });
    });

    //edit bank
    $('#formEditBank').submit(function (e) {
        e.preventDefault();
        let url = $(this).attr('action') + '/' + $(this).find($('input[name="id"]')).val();
        $('button[type=submit]').prop('disabled', true);
        $(this).find($('[data-number]')).each(function () {
            $(this).val(getNumber($(this)));
        });

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
            $("#formEditBank")[0].reset();
            $('button[type=submit]').prop('disabled', false);
            $('#dt_bank').DataTable().ajax.reload();
            $('#modalEditBank').modal('hide');
        });
    });

    //hapus bank
    $('#dt_bank').on('click', '[data-hapus]', function (e) {
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
            $('#dt_bank').DataTable().ajax.reload();
        });
    });

    //create bank
    $('#formCreateBank').submit(function (e) {
        e.preventDefault();
        $('button[type=submit]').prop('disabled', true);
        $(this).find($('[data-number]')).each(function () {
            $(this).val(getNumber($(this)));
        });

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
            $("#formCreateBank")[0].reset();
            $('button[type=submit]').prop('disabled', false);
            $('#dt_bank').DataTable().ajax.reload();
        });
    });

    $('#dt_bln_masuk').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

});

