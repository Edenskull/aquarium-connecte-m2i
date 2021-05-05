<div class="grid-container">
    <div class="sidenav">
        <img src="./assets/logo-krevett.png">
        <ul class="sidenav__list">
            <li class="sidenav__list-item">Mon aquarium</li>
            <li class="sidenav__list-item">Ajouter un aquarium</li>
        </ul>
    </div>
    <div class="main">
        <div class="main-overview">
            <div class="overviewcard">
                <div class="overviewcard__icon">Temperature</div>
                <div class="overviewcard__info" id="temperature"></div>
            </div>
            <div class="overviewcard" id="cardPh">
                <div class="overviewcard__icon">PH</div>
                <div class="overviewcard__info" id="ph"></div>
            </div>
            <div class="overviewcard">
                <div class="overviewcard__icon">Humidite</div>
                <div class="overviewcard__info" id="humidite"></div>
            </div>
        </div>
        <div class="main-cards">
            <div class="card w-100"><canvas id="chart"></canvas></div>
        </div>
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
                        }, {
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