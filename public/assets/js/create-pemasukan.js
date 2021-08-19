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
    
    // create pemasukan
    $("#addRow").click(function (e) {
        e.preventDefault();
        var html = '';
        html += `
        <div class="mb-2" id="inputFormRow">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jumlah Uang</label>
                        <input type="number" class="form-control" name="jumlah[]" required="required">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bank</label>
                        <div class="d-flex">
                            <div class="input-group">
                                <select name="bank[]" class="form-control" required="required">
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
        
    });
    $(document).on('click', '#removeRow', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRow').remove();
    });
    
});