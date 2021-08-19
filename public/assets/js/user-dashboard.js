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
        "order": [[1, "desc"]]
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
            ],
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
    
});