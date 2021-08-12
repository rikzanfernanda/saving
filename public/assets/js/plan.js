$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");
    const csrf_token = $("meta[name='csrf_token']").attr("content");
    
    $('#dt_bln_anggaran').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

    $('input[name="simpan"]').each(function () {
        $('input[name="simpan"]').click(function (e) {
            e.preventDefault();
            let row = $(this).parent().parent();
            let id = row.find($('input[name="id"]')).val();
            let data = {
                "_token": csrf_token,
                "id_anggaran": row.find($('select[name="id_anggaran"]')).val(),
                "jumlah": row.find($('input[name="jumlah"]')).val(),
                "frekuensi": row.find($('input[name="frekuensi"]')).val(),
                "satuan": row.find($('select[name="satuan"]')).val(),
                "bulan": row.find($('input[name="bulan"]')).val(),
                "tahun": row.find($('input[name="tahun"]')).val(),
            };

            $.ajax({
                url: base_url + '/plan/update/' + id,
                type: "POST",
                data: data
            }).done(function () {
                window.location.reload();
            });
        });
    });

    $('input[name="jumlah[]"]').keyup(function () {
        let jumlah = $(this).val();
        let frekuensi = $('input[name="frekuensi[]"]').val();
        let satuan = $('select[name="satuan[]"]').val();
        let total = $('input[name="total[]"]').val();
        if (satuan === "Sehari") {
            total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
        } else if (satuan === "Seminggu") {
            total = jumlah * frekuensi * 4;
        } else {
            total = jumlah * frekuensi;
        }
        $('input[name="total[]"]').val(total);
    });

    $('input[name="frekuensi[]"]').keyup(function () {
        let frekuensi = $(this).val();
        let jumlah = $('input[name="jumlah[]"]').val();
        let satuan = $('select[name="satuan[]"]').val();
        let total = $('input[name="total[]"]').val();
        if (satuan === "Sehari") {
            total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
        } else if (satuan === "Seminggu") {
            total = jumlah * frekuensi * 4;
        } else {
            total = jumlah * frekuensi;
        }
        $('input[name="total[]"]').val(total);
    });

    $('[data-edit]').each(function () {
        $('[data-edit]').click(function (e) {
            e.preventDefault();
            let id_edit = $(this).attr('data-edit');
            $(this).parent().parent().addClass('d-none');
            $('#row-' + id_edit).removeClass('d-none');
        })
    })

    $('[data-hapus]').each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            $(this).parent().parent().remove();
            let url = $(this).attr('href');
            $.ajax({
                type: "GET",
                url: url
            }).done(function () {
                window.location.reload();
            });
        });
    });

    $('[data-cancel]').each(function () {
        $('[data-cancel]').click(function (e) {
            e.preventDefault();
            let id_edit = $(this).attr('data-cancel');
            $(this).parent().parent().addClass('d-none');
            console.log(id_edit);
            $('#tr-' + id_edit).removeClass('d-none');
        });
    });

    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    $('select[name="satuan[]"]').change(function () {
        let row = $(this).parent().parent().parent().parent().parent();
        let jumlah = row.find($('input[name="jumlah[]"]')).val();
        let frekuensi = row.find($('input[name="frekuensi[]"]')).val();
        let satuan = $(this).val();
        let total = 0;
        if (satuan === "Sehari") {
            total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
        } else if (satuan === "Seminggu") {
            total = jumlah * frekuensi * 4;
        } else {
            total = jumlah * frekuensi;
        }

        row.find($('input[name="total[]"]')).val(total);
    });
    // add row
    $("#addRow").click(function (e) {
        e.preventDefault();
        var html = '';
        html += '<div class="row pt-2 mb-2" id="inputFormRow">';
        html += '<div class="col-md-3 col-6">';
        html += '<div class="form-group">';
        html += '<label class="">Anggaran</label>';
        html += '<select name="id_anggaran[]" class="form-control">';
        html += `</select>`;
        html += `</div>`;
        html += `</div>`;
        html += `<div class="col-md-3 col-6">`;
        html += `<div class="form-group">`;
        html += `<label class="">Jumlah</label>`;
        html += `<div class="input-group"><div class="input-group-prepend"><div class="input-group-text form-control">Rp.</div></div>`;
        html += `<input type="number" name="jumlah[]" class="form-control">`;
        html += `</div>`;
        html += `</div>`;
        html += `</div>`;
        html += `<div class="col-md-3 col-6">`;
        html += `<div class="form-group">`;
        html += `<label class="">Frekuensi</label>`;
        html += `<div class="d-flex">`;
        html += `<div class="input-group"><input type="number" name="frekuensi[]" class="form-control">`;
        html += `<div class="input-group-append"><div class="input-group-text form-control">X</div></div>`;
        html += `</div>`;
        html += `<div class="ml-2 w-100"><select name="satuan[]" class="form-control"><option value="" class="form-control"></option><option value="Sehari" class="form-control">Sehari</option><option value="Seminggu" class="form-control">Seminggu</option><option value="Sebulan" class="form-control">Sebulan</option></select></div>`;
        html += `</div></div></div>`;
        html += `<div class="col-md-3 col-6">`;
        html += `<div class="form-group"><label class="">Total</label>`;
        html += `<div class="input-group"><div class="input-group-prepend"><div class="input-group-text form-control">Rp.</div></div><input type="number" name="total[]" class="form-control" readonly="readonly"><div><button id="removeRow" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button></div>`;
        html += `</div></div></div>`;
        $('#newRow').append(html);

        let row = $('#newRow').children().last();
        let select = row.find($('select[name="id_anggaran[]"]'));
        $.ajax({
            url: base_url + '/anggaran/option',
            type: "GET"
        }).done(function (respon) {
            let data = JSON.parse(respon);
            select.html('');
            $.each(data, function () {
                select.append('<option value="' + this.id + '">' + this.nama + '</option>');
            })
        });

        $('input[name="jumlah[]"]').keyup(function () {
            let row = $(this).parent().parent().parent().parent().parent();
            let jumlah = $(this).val();
            let frekuensi = row.find($('input[name="frekuensi[]"]')).val();
            let satuan = row.find($('select[name="satuan[]"]')).val();
            let total = row.find($('input[name="total[]"]')).val();
            if (satuan === "Sehari") {
                total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
            } else if (satuan === "Seminggu") {
                total = jumlah * frekuensi * 4;
            } else {
                total = jumlah * frekuensi;
            }
            row.find($('input[name="total[]"]')).val(total);
        });

        $('input[name="frekuensi[]"]').keyup(function () {
            let row = $(this).parent().parent().parent().parent().parent();
            let frekuensi = $(this).val();
            let jumlah = row.find($('input[name="jumlah[]"]')).val();
            let satuan = row.find($('select[name="satuan[]"]')).val();
            let total = row.find($('input[name="total[]"]')).val();
            if (satuan === "Sehari") {
                total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
            } else if (satuan === "Seminggu") {
                total = jumlah * frekuensi * 4;
            } else {
                total = jumlah * frekuensi;
            }
            row.find($('input[name="total[]"]')).val(total);
        });

        $('select[name="satuan[]"]').change(function () {
            let row = $(this).parent().parent().parent().parent().parent();
            let jumlah = row.find($('input[name="jumlah[]"]')).val();
            let frekuensi = row.find($('input[name="frekuensi[]"]')).val();
            let satuan = $(this).val();
            let total = 0;
            if (satuan === "Sehari") {
                total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
            } else if (satuan === "Seminggu") {
                total = jumlah * frekuensi * 4;
            } else {
                total = jumlah * frekuensi;
            }

            row.find($('input[name="total[]"]')).val(total);
        });
    });
    // remove row
    $(document).on('click', '#removeRow', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRow').remove();
    });
    
});

