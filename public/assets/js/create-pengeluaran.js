$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

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
                        <input type="number" class="form-control" name="jumlah[]" required="required">
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