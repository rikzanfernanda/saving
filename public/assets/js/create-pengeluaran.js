$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

    $('#formCreatePengeluaran').submit(function (e) {
        $('[data-number]').each(function () {
            $(this).val(getNumber($(this)));
            $('button[type=submit]').prop('disabled',true);
        });
        return true;
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

    // select2 bank row 1
    $('select[name="bank[]"]').select2({
        ajax: {
            url: base_url + '/bank/option',
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
        }
    });

    // select2 anggaran row 1
    $('select[name="anggaran[]"]').select2({
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

    // create pengeluaran
    $("#addRow").click(function (e) {
        e.preventDefault();
        var html = '';
        html += `
        <div class="mb-3" id="inputFormRow">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Jumlah Uang</label>
                        <input type="text" class="form-control" name="jumlah[]" required="required" data-number="true">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bank</label>
                        <select name="bank[]" class="form-control">
                            <option value="" class="form-control">---</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Anggaran</label>
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="anggaran[]" class="form-control select-anggaran">
                                    <option value="" class="form-control">---</option>
                                </select>
                            </div>
                            <div class="">
                                <button id="removeRow" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        `;
        $('#newRow').append(html);
        
        // format number row tambahan
        $('[data-number="true"]').each(function () {
            $(this).keyup(function () {
                $(this).val(formatRupiah($(this).val(), "Rp. "));
            });
        });

        // select2 bank row tambahan
        $('select[name="bank[]"]').select2({
            ajax: {
                url: base_url + '/bank/option',
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
            }
        });

        // select2 anggaran row tambahan
        $('select[name="anggaran[]"]').select2({
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
    });

    //remove button
    $(document).on('click', '#removeRow', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRow').remove();
    });

});