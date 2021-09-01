$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");
    const csrf_token = $("meta[name='csrf_token']").attr("content");

    // index
    $('#dt_bln_anggaran').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

    // select2 anggaran in index
    $('select[name="id_anggaran"]').select2({
        ajax: {
            url: base_url + '/anggaran/option',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: $.map(response, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                }
            }
        },
        tags: true,
        createTag: function (params) {
            return {
                id: params.term,
                text: params.term,
                newOption: true
            }
        },
        templateResult: function (data) {
            var $result = $('<span></span>')
            $result.text(data.text)
            if (data.newOption)
                $result.append('<em> (add new)</em>')
            return $result
        }
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
            $('#tr-' + id_edit).removeClass('d-none');
        });
    });

    $('input[name="simpan"]').each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            $(this).prop('disabled', true);
            let row = $(this).parent().parent();
            let id = row.find($('input[name="id"]')).val();
            let data = {
                "_token": csrf_token,
                "id_anggaran": row.find($('select[name="id_anggaran"]')).val(),
                "jumlah": getNumber(row.find($('input[name="jumlah"]'))),
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

    // form
    // select2 anggaran row 1
    $('#formCreatePlan').submit(function (e) {
        e.preventDefault();
        $('[data-number]').each(function () {
            $(this).val(getNumber($(this)));
        });
        $('button[type=submit]').prop('disabled', true);
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
            $("#formCreatePlan")[0].reset();
            $('button[type=submit]').prop('disabled', false);
        });
    });

    $('select[name="id_anggaran[]"]').select2({
        ajax: {
            url: base_url + '/anggaran/option',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: $.map(response, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                }
            }
        },
        tags: true,
        createTag: function (params) {
            return {
                id: params.term,
                text: params.term,
                newOption: true
            }
        },
        templateResult: function (data) {
            var $result = $('<span></span>')
            $result.text(data.text)
            if (data.newOption)
                $result.append('<em> (add new)</em>')
            return $result
        }
    });

    $('input[name="jumlah[]"]').keyup(function () {
        let row = $(this).parent().parent().parent().parent();
        let jumlah = getNumber($(this));
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

        row.find($('input[name="total[]"]')).val(formatRupiah(total.toString(), "Rp. "));
    });

    $('input[name="frekuensi[]"]').keyup(function () {
        let row = $(this).parent().parent().parent().parent().parent();
        let frekuensi = $(this).val();
        let jumlah = getNumber(row.find($('input[name="jumlah[]"]')));
        let satuan = row.find($('select[name="satuan[]"]')).val();
        let total = row.find($('input[name="total[]"]')).val();
        if (satuan === "Sehari") {
            total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
        } else if (satuan === "Seminggu") {
            total = jumlah * frekuensi * 4;
        } else {
            total = jumlah * frekuensi;
        }
        row.find($('input[name="total[]"]')).val(formatRupiah(total.toString(), "Rp. "));
    });

    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    $('select[name="satuan[]"]').change(function () {
        let row = $(this).parent().parent().parent().parent().parent();
        let jumlah = getNumber(row.find($('input[name="jumlah[]"]')));
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

        row.find($('input[name="total[]"]')).val(formatRupiah(total.toString(), "Rp. "));
    });

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

    // format number row 1
    $('[data-number="true"]').each(function () {
        $(this).keyup(function () {
            $(this).val(formatRupiah($(this).val(), "Rp. "));
        });
    });

    // add row
    $("#addRow").click(function (e) {
        e.preventDefault();
        var html = '';
        html += '<div class="row pt-2 mb-2" id="inputFormRow">';
        html += '<div class="col-md-3 col-6">';
        html += '<div class="form-group">';
        html += '<label class="">Anggaran</label>';
        html += '<select name="id_anggaran[]" class="form-control" required="required"><option value="">---</option>';
        html += `</select>`;
        html += `</div>`;
        html += `</div>`;
        html += `<div class="col-md-3 col-6">`;
        html += `<div class="form-group">`;
        html += `<label class="">Jumlah</label>`;
        html += `<div class="input-group">`;
        html += `<input type="text" name="jumlah[]" class="form-control" required="required" data-number="true">`;
        html += `</div>`;
        html += `</div>`;
        html += `</div>`;
        html += `<div class="col-md-3 col-6">`;
        html += `<div class="form-group">`;
        html += `<label class="">Frekuensi</label>`;
        html += `<div class="d-flex">`;
        html += `<div class="input-group"><input type="number" name="frekuensi[]" class="form-control" required="required">`;
        html += `<div class="input-group-append"><div class="input-group-text form-control">X</div></div>`;
        html += `</div>`;
        html += `<div class="ml-2 w-100"><select name="satuan[]" class="form-control" required="required"><option value="" class="form-control"></option><option value="Sehari" class="form-control">Sehari</option><option value="Seminggu" class="form-control">Seminggu</option><option value="Sebulan" class="form-control">Sebulan</option></select></div>`;
        html += `</div></div></div>`;
        html += `<div class="col-md-3 col-6">`;
        html += `<div class="form-group"><label class="">Total</label>`;
        html += `<div class="input-group"><input type="text" name="total[]" class="form-control" readonly="readonly" required="required" data-number="true"><div><button id="removeRow" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button></div>`;
        html += `</div></div></div>`;
        $('#newRow').append(html);

        // format number row 1
        $('[data-number="true"]').each(function () {
            $(this).keyup(function () {
                $(this).val(formatRupiah($(this).val(), "Rp. "));
            });
        });

//        let row = $('#newRow').children().last();
        // select2 anggaran row tambahan
        $('select[name="id_anggaran[]"]').select2({
            ajax: {
                url: base_url + '/anggaran/option',
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (response) {
                    return {
                        results: $.map(response, function (item) {
                            return {
                                text: item.nama,
                                id: item.id
                            }
                        })
                    }
                }
            },
            tags: true,
            createTag: function (params) {
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true
                }
            },
            templateResult: function (data) {
                var $result = $('<span></span>')
                $result.text(data.text)
                if (data.newOption)
                    $result.append('<em> (add new)</em>')
                return $result
            }
        });

        $('input[name="jumlah[]"]').keyup(function () {
            let row = $(this).parent().parent().parent().parent();
            let jumlah = getNumber($(this));
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

            row.find($('input[name="total[]"]')).val(formatRupiah(total.toString(), "Rp. "));
        });

        $('input[name="frekuensi[]"]').keyup(function () {
            let row = $(this).parent().parent().parent().parent().parent();
            let frekuensi = $(this).val();
            let jumlah = getNumber(row.find($('input[name="jumlah[]"]')));
            let satuan = row.find($('select[name="satuan[]"]')).val();
            let total = row.find($('input[name="total[]"]')).val();
            if (satuan === "Sehari") {
                total = jumlah * frekuensi * daysInMonth($('select[name="bulan"]').val(), $('select[name="tahun"]').val());
            } else if (satuan === "Seminggu") {
                total = jumlah * frekuensi * 4;
            } else {
                total = jumlah * frekuensi;
            }
            row.find($('input[name="total[]"]')).val(formatRupiah(total.toString(), "Rp. "));
        });

        $('select[name="satuan[]"]').change(function () {
            let row = $(this).parent().parent().parent().parent().parent();
            let jumlah = getNumber(row.find($('input[name="jumlah[]"]')));
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

            row.find($('input[name="total[]"]')).val(formatRupiah(total.toString(), "Rp. "));
        });
    });
    // remove row
    $(document).on('click', '#removeRow', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRow').remove();
    });

});

