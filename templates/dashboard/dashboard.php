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
    var data = $.ajax({
        url: 'modules/request_temperature.php',
        type: 'GET',
        data: 'limite=2',
        dataType: 'json',
        success: function(data, status) {
            var temperature = [];
            var time = [];
            data = data.reverse();
            for (let entry of data) {
                time.push(entry.timestamp);
                temperature.push(entry.temperature);
            }
            console.log(time);
            console.log(temperature);
            var ctx = $("#chart").get(0).getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: time,
                    datasets: [{
                        label: 'Temperature by Time',
                        data: temperature,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });
        }
    });
</script>