function checkAccess() {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=checkAccess&aquaId=' + sessionStorage.getItem('currentAquarium'),
        type: 'POST',
        dataType: 'json'
    }).fail(function() {
        sessionStorage.clear();
        window.location.href = "index.html"
    });
}

function getAquarium() {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=aquarium',
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        console.log(result)
        result.forEach(element => {
            $("#listAquarium").append('<button id="' + element['id'] + '" type="button" class="list-group-item list-group-item-action">' + element['name'] + '</button>');
        });
        if(sessionStorage.getItem('currentAquarium')){
            getLastData();
            if($("#dashboard").css('display') == "none") {
                $("#dashboard").show();
                $("#information").hide();
            }
        }
        $("#listAquarium button").click(function() {
            let currentId = $(this).attr('id');
            sessionStorage.setItem('currentAquarium', currentId);
            getLastData();
            getLights();
            getFoods();
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
        let temperature = (result.temperature == undefined) ? "No Data" : result.temperature + "°celsius";
        let ph = (result.ph == undefined) ? "No Data" : "PH " + result.ph;
        let humidite = (result.humidite == undefined) ? "No Data" : result.humidite + " %";
        $("#temperatureValue").text(temperature);
        $("#phValue").text(ph);
        $("#humiditeValue").text(humidite);
        createGraph();
    });
}

function getLights() {
    $("#bodyLight").empty();
    let status;
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=getLights&aquaId=' + sessionStorage.getItem('currentAquarium'),
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        result.forEach(function(row) {
            if(row['status'] == 0) {
                status = '<button type="button" class="btn btn-outline-primary" id="' + row['id'] + '">On</button>';
            } else {
                status = '<button type="button" class="btn btn-primary" id="' + row['id'] + '">Off</button>';
            }
            $("#bodyLight").append('<tr><th scope="row">' + row['id'] + '</th><td>' + row['name'] + '</td><td>' + status + '</td></tr>')
        });
        $("td button").click(function() {
            let currentId = $(this).attr('id');
            let currentStatus = $(this).text();
            $.ajax({
                url: 'modules/request_data.php',
                data: 'mode=updateLight&lightId=' + currentId + '&status=' + currentStatus,
                type: 'POST',
                dataType: 'json'
            }).done(function() {
                window.location.href = "index.html"
            });
        });
    });
}

function getFoods() {
    let status;
    $("#bodyFood").empty();
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=getFoods&aquaId=' + sessionStorage.getItem('currentAquarium'),
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        result.forEach(function(row) {
            if(row['status'] == 0) {
                status = '<button type="button" class="btn btn-outline-primary" id="' + row['id'] + '">On</button>';
            } else {
                status = '<button type="button" class="btn btn-primary" id="' + row['id'] + '">Off</button>';
            }
            $("#bodyFood").append('<tr><th scope="row">' + row['id'] + '</th><td>' + row['name'] + '</td><td>' + status + '</td></tr>')
        });
        $("td button").click(function() {
            let currentId = $(this).attr('id');
            let currentStatus = $(this).text();
            $.ajax({
                url: 'modules/request_data.php',
                data: 'mode=updateFood&foodId=' + currentId + '&status=' + currentStatus,
                type: 'POST',
                dataType: 'json'
            }).done(function() {
                window.location.href = "index.html"
            });
        });
    });
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
    });
}

function addLight(name) {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=addLight&aquaId=' + sessionStorage.getItem('currentAquarium') + '&lightName=' + name,
        type: 'POST',
        dataType: 'json'
    }).done(function() {
        window.location.href = "index.html"
    }).fail(function(result) {
        displayToast(result.responseJSON.message, "Light System");
    });
}

function addFood(name) {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=addFood&aquaId=' + sessionStorage.getItem('currentAquarium') + '&foodName=' + name,
        type: 'POST',
        dataType: 'json'
    }).done(function() {
        window.location.href = "index.html"
    }).fail(function(result) {
        displayToast(result.responseJSON.message, "Food System");
    });
}

function addAqua(name) {
    $.ajax({
        url: 'modules/request_data.php',
        data: 'mode=addAqua&aquaName=' + name,
        type: 'POST',
        dataType: 'json'
    }).done(function() {
        window.location.href = "index.html"
    }).fail(function(result) {
        displayToast(result.responseJSON.message, "Aquarium System");
    });
}

function displayToast(message, title) {
    toastr.error(message, title, {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "0",
        "hideDuration": "0",
        "timeOut": "0",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    });
}