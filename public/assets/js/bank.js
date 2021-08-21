$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

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

    $.ajax({
        url: base_url + '/bank/dt',
        type: "GET"
    }).done(function (data) {
        let bank = JSON.parse(data)
        for (var i = 0; i < bank.length; i++) {
            bank[i].tindakan = '<a href="' + base_url + '/bank/show/' + bank[i].id + '" class="text-green" data-edit="' + bank[i].id + '" data-toggle="modal" data-target="#modalEditBank"><i class="fas fa-edit"></i></a> <a href="' + base_url + '/bank/destroy/' + bank[i].id + '" class="ml-2 text-red" data-hapus="' + bank[i].id + '"><i class="fas fa-trash"></i></a>'
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
                {"width": "10%", "targets": 2},
                {className: "text-right", "targets": [1]}
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
                });
            });
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
                        $('[data-number]').each(function () {
                            $(this).val(getNumber($(this)));
                        });

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

    // format number row 1
    $('[data-number="true"]').each(function () {
        $(this).keyup(function () {
            $(this).val(formatRupiah($(this).val(), "Rp. "));
        });
    });

    //create bank
    $('#formCreateBank').submit(function (e) {
        e.preventDefault();
        $('[data-number]').each(function () {
            $(this).val(getNumber($(this)));
        });

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

    $('#dt_bln_masuk').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

});

