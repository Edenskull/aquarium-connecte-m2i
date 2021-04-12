<div id="corps" class="container-fluid">
    <div class="row">
        <nav class="sidebar col-md-3 col-lg-2 d-md-block bg-dark collapse">

        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 p-4">
            <div class="row">
                <div class="col-xl-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12">
                                <div id="cardTemperature" class="card text-light bg-info mb-3">
                                    <div class="card-header">Température actuelle (°c)</div>
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                <i class="card-icon bi bi-thermometer-half float-right"></i>
                                            </div>
                                            <div class="media-body text-end">
                                                <h2 id="temperature"></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12">
                                <div id="cardPh" class="card text-light bg-info mb-3">
                                    <div class="card-header">Potentiel hydrogène (PH)</div>
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                <i class="card-icon bi bi-droplet-fill float-right"></i>
                                            </div>
                                            <div class="media-body text-end">
                                                <h2 id="ph"></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12">
                                <div id="cardHumidite" class="card text-light bg-info mb-3">
                                    <div class="card-header">Humidité (%)</div>
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                <i class="card-icon bi bi-clouds-fill float-right"></i>
                                            </div>
                                            <div class="media-body text-end">
                                                <h2 id="humidite"></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10 col-md-12 col-sm-12 col-12">
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
    $(function() {
        $.ajax({
            url: 'modules/request_data.php',
            type: 'GET',
            data: 'limite=10',
            dataType: 'json',
            success: function(data) {
                let lastTemperature = 0;
                let lastPh = 0;
                let temperature = [];
                let ph = [];
                let humidite = [];
                let time = [];
                data = data.reverse();
                for (let entry of data) {
                    time.push(entry.timestamp);
                    temperature.push(entry.temperature);
                    ph.push(entry.ph);
                    humidite.push(entry.humidite);
                    lastTemperature = entry.temperature;
                    lastHumidite = entry.humidite;
                    lastPh = entry.ph;
                }
                $("#temperature").text(Math.round(lastTemperature * 10) / 10 + "°");
                $("#humidite").text(Math.floor(lastHumidite) + "%");
                $("#ph").text("ph " + Math.round(lastPh * 10) / 10);
                $("#cardPh").addClass("ph-" + Math.floor(lastPh));
                let ctx = $("#chart").get(0).getContext('2d');
                let myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: time,
                        datasets: [{
                            label: 'Temperature by Time',
                            data: temperature,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        },{
                            label: 'Ph by Time',
                            data: ph,
                            fill: false,
                            borderColor: 'rgb(180, 50, 20)',
                            tension: 0.1
                        }]
                    }
                });
            }
        });
    });
</script>