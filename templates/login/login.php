<div class="login-wrapper d-flex">
    <div class="left-container d-flex justify-content-start align-items-center">
        <div class="login-container d-flex">
            <div class="container">
                <form id="sign" class="" style="display: none;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group w-100">
                                <label for="pwd1">Password:</label>
                                <input type="password" class="form-control" id="pwd1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group w-100">
                                <label for="pwd2">Confirm Password:</label>
                                <input type="password" class="form-control" id="pwd2">
                            </div>
                        </div>
                    </div>
                    <button id="signin" type="button" class="btn btn-secondary mt-2">Sign in</button>
                    <button id="switch2" type="button" class="btn btn-secondary mt-2">Go to Login</button>
                </form>
                <form id="conn" class="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="usernamelog">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group w-100">
                                <label for="pwdlog">Password:</label>
                                <input type="password" class="form-control" id="pwdlog">
                            </div>
                        </div>
                    </div>
                    <button id="connect" type="button" class="btn btn-secondary mt-2">Connect</button>
                    <button id="switch1" type="button" class="btn btn-secondary mt-2">No account</button>
                </form>
            </div>
        </div>
    </div>
    <div class="right-container">
        <h1 class="gras">Aquarium Connecté</h1>
        <h1 class="gras">M2I</h1>
        <h1 class="gras">@2021</h1>
    </div>
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div style="position: absolute; top: 0; right: 0;"></div>
    </div>
</div>

<script>
    $(function() {
        $("#switch1").click(function(e) {
            $("#conn").toggle();
            $("#sign").toggle();
        });
        $("#switch2").click(function(e) {
            $("#conn").toggle();
            $("#sign").toggle();
        });
        $("#connect").click(function(e) {
            e.preventDefault();
            let username = $("#usernamelog").val();
            let pwd = $("#pwdlog").val();
            $.ajax({
                url: 'modules/connexion.php',
                type: 'POST',
                data: 'mode=connect&username=' + username + '&pwd=' + pwd,
                dataType: 'JSON',
                success: function(response, status) {
                    if(response.statusCode == 200) {
                        toastr.success(response.message);
                        sessionStorage.setItem('view', 'dashboard');
                        changePage();
                    }
                },
                error: function(response, status, error) {
                    toastr.error(response.responseJSON.message);
                }
            });
        });
        $("#signin").click(function(e) {
            e.preventDefault();
            let username = $("#username").val();
            let pwd = $("#pwd1").val();
            let pwdc = $("#pwd2").val();
            if (pwd != "" && pwdc != "" && username != "") {
                if (pwd == pwdc) {
                    $.ajax({
                        url: 'modules/connexion.php',
                        type: 'POST',
                        data: 'mode=signin&username=' + username + '&pwd=' + pwd,
                        dataType: 'JSON',
                        success: function(response, status) {
                            if(response.statusCode == 200) {
                                toastr.success(response.message);
                                $("#conn").toggle();
                                $("#sign").toggle();
                            }
                        },
                        error: function(response, status) {
                            toastr.error(response.responseJSON.message);
                        }
                    });
                } else {
                    toastr.error('The password doesn\'t match.', 'Error');
                }
            } else {
                toastr.error('Fill the form.', 'Error');
            }
        })
    });
</script>