function getAquarium() {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=aquarium',
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        console.log(result)
        result.forEach(element => {
            $("#listAquarium").append('<a href="#" class="nav-link text-white" id="' + element['id'] + '"><i class="bi bi-play-fill"></i></i>' + element['name'] + '</a>')
        });
        $("#listAquarium a").click(function() {
            let currentId = $(this).attr('id');
            sessionStorage.setItem('currentAquarium', currentId);
            getLastData();
            if($("#dashboard").css('display') == "none") {
                $("#dashboard").show();
                $("#information").hide();
            }
        });
    }).fail(function(result) {
        console.log(result);
    });
}

function getLastData() {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=getlastdata&aquaId=' + sessionStorage.getItem('currentAquarium'),
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        $("#temperatureValue").text(result.temperature + "°celsius");
        $("#phValue").text("PH " + result.ph);
        $("#humiditeValue").text(result.humidite + " %");
        createGraph();
    })
}

function createGraph() {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=getlasttendata&aquaId=' + sessionStorage.getItem('currentAquarium'),
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        let temperatures = [];
        let phs = [];
        let humidites = [];
        let times = [];
        result = result.reverse();
        result.forEach(function(row) {
            temperatures.push(row.temperature);
            times.push(row.timestamp);
            phs.push(row.ph);
            humidites.push(row.humidite);
        });
        createGraphInstance(times, temperatures, phs, humidites);
    })
}