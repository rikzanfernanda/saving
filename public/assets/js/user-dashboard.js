$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

    $('#bln_anggaran').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

    $('#total_anggaran').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });
    
    $('#dt_history').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });
    
    $('#dt_plan').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

    $.ajax({
        url: base_url + '/history/chart',
        type: "GET"
    }).done(function (respon) {
        let chart = JSON.parse(respon)

        const labels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        const data = {
            labels: labels,
            datasets: [{
                    type: 'bar',
                    label: 'Pemasukan',
                    backgroundColor: 'rgb(0, 214, 111)',
                    borderColor: 'rgb(0, 214, 111)',
//                data: [0, 10, 5, 2, 20, 30, 45, 50, 80, 20, 45, 35],
                    data: chart.pemasukan
                }, {
                    type: 'bar',
                    label: 'Pengeluaran',
                    backgroundColor: 'rgb(100, 99, 132)',
                    borderColor: 'rgb(100, 99, 132)',
//                    data: [5, 3, 10, 1, 10, 25, 15, 25, 45, 30, 30, 10],
                    data: chart.pengeluaran
                }
            ]
        };
        const config = {
            data: data,
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        var myChart = new Chart(
                document.getElementById('myChart'),
                config
                );

    });

    // create pengeluaran
    $("#addRow").click(function (e) {
        e.preventDefault();
        var html = '';
        html += `
        <div class="border-top pt-2" id="inputFormRow">
            <div class="text-right">
                <button id="removeRow" class="btn btn-danger ml-2"><i class="fas fa-trash"></i> Remove</button>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah Uang</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah[]" required="required">
            </div>
            <div class="form-group">
                <label for="bank">Bank</label>
                <select id="bank" name="bank[]" class="form-control">
                </select>
            </div>
            <div class="form-group">
                <label for="anggaran">Anggaran</label>
                <select id="anggaran" name="anggaran[]" class="form-control">
                </select>
            </div>
        </div>
        `;
        $('#newRow').append(html);
        
        let row = $('#newRow').children().last();
        $.ajax({
            url: base_url + '/bank/option',
            type: "GET"
        }).done(function (respon) {
            let data = JSON.parse(respon);
            row.find($('select[name="bank[]"]')).html('');
            $.each(data, function () {
                row.find($('select[name="bank[]"]')).append('<option value="' + this.id + '">' + this.nama + '</option>');
            });
        });
        $.ajax({
            url: base_url + '/anggaran/option',
            type: "GET"
        }).done(function (respon) {
            let data = JSON.parse(respon);
            row.find($('select[name="anggaran[]"]')).html('');
            $.each(data, function () {
                row.find($('select[name="anggaran[]"]')).append('<option value="' + this.id + '">' + this.nama + '</option>');
            });
        });
    });
    $(document).on('click', '#removeRow', function (e) {
        e.preventDefault();
        $(this).closest('#inputFormRow').remove();
    });


});