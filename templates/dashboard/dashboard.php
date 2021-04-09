<div id="corps" class="container-fluid">
    <div class="row">
        <nav class="sidebar col-md-3 col-lg-2 d-md-block bg-dark collapse">

        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 p-4">
            <div class="row">
                <div class="col-xl-2 col-md-2 col-sm-4 col-12">
                    <div class="col-12">
                        <div class="card text-light bg-info mb-3">
                            <div class="card-header">Température actuelle</div>
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="card-icon bi bi-thermometer-half float-right"></i>
                                    </div>
                                    <div class="media-body text-end">
                                        <h2>20°</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10 col-md-10 col-sm-8 col-12">
                    <div class="card text-light bg-light">
                        <div class="card-body">
                            <canvas id="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    var ctx = $("#chart").get(0).getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>