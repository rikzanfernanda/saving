$(document).ready(function () {
    const base_url = $("meta[name='base_url']").attr("content");

    $.ajax({
        url: base_url + '/user/chart',
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
                    label: 'User',
                    backgroundColor: 'rgb(0, 214, 111)',
                    borderColor: 'rgb(0, 214, 111)',
//                data: [0, 10, 5, 2, 20, 30, 45, 50, 80, 20, 45, 35],
                    data: chart
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

    $('#dt_user').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });
    
    $('#dt_feedback').DataTable({
        "processing": true,
        "paging": false,
        "dom": 'lrtip',
        "scrollX": true,
        "scrollCollapse": true,
    });

});