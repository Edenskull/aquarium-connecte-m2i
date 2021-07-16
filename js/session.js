function isConnected() {
    $.ajax({
        url: 'modules/session.php',
        data: 'mode=isconnected',
        type: 'POST',
        dataType: 'json'
    }).done((result) => {
        if(result.connected == "false"){
            window.location.href = "http://localhost/aquarium-connecte-m2i/login.html"
        }
    });
}

function register(username, password, email) {
    $.ajax({
        url: 'modules/session.php',
        data: 'mode=register&login=' + username + '&email=' + email + '&password=' + password,
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        displayToast(result.message, "Account System");
    }).fail(function(result) {
        displayToast(result.responseJSON.message, "Account System");
    });
}

function login(username, password) {
    $.ajax({
        url: 'modules/session.php',
        data: 'mode=login&login=' + username + '&password=' + password,
        type: 'POST',
        dataType: 'json'
    }).done(function() {
        window.location.href = "index.html";
    }).fail(function(result) {
        displayToast(result.responseJSON.message, "Account System");
    });
}

function disconnect() {
    sessionStorage.clear();
    $.ajax({
        url: 'modules/session.php',
        data: 'mode=disconnect',
        type: 'POST',
        dataType: 'json'
    }).done(function(result) {
        window.location.href = "login.html"
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