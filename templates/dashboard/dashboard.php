<div class="grid-container">
    <div id="menu-button" class="burger">
        <img src="./assets/Hamburger_icon.svg.png">
    </div>
    <div class="sidenav" id="menu">
        <div class="logout"><img src="./assets/logout.png" id="logout"></div>
        <div class="krevett"><img src="./assets/krevett.png"></div>
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
            <div class="card w-50 light">
                <div class="card-title">Ampoule 1</div>
                <img src="./assets/ampoule.png" id="ampoule">
                <div class="light-switch">
                    <div class="switch-text">OFF</div>
                    <label class="switch">
                      <input type="checkbox" id="switch-box">
                      <span class="slider round"></span>
                    </label>
                    <div class="switch-text">ON</div>
                </div>
                <button>Envoyer</button>
            </div>
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
    var switchButton = document.querySelector('#switch-box');

    switchButton.addEventListener('click',function(){
      var ampoule = document.getElementById("ampoule");
      var statelight = ampoule.getAttribute("src");
      if(statelight == "./assets/ampoule.png")
        statelight = "./assets/ampoule-on.png";
      else
        statelight = "./assets/ampoule.png";
      ampoule.setAttribute("src", statelight);
      ampoule.classList.toggle('shine');
    });

    var menuButton = document.querySelector('#menu-button');
    var menu = document.querySelector('#menu');

    $("#logout").click(function(){
        $.get('modules/connexion.php?mode=disco');
        sessionStorage.setItem('view', 'login');
        changePage();
    })

    // show or hide
    menuButton.addEventListener('click',function(){
      menu.classList.toggle('show-menu');
      menuButton.classList.toggle('close');
    });
</script>