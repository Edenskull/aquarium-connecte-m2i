<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<?php

include('templates/core/head.php');

?>

<body>

    <?php
        
        include('templates/core/body.php');

    ?>

    <script>
        $(function() {
            if(sessionStorage.getItem('view') == undefined) {
                sessionStorage.setItem('view', 'login');
            }
            changePage();
        });

        function changePage() {
            $("body").load("templates/" + sessionStorage.getItem('view') + "/" + sessionStorage.getItem('view') + ".php");
            $("#pageTitle").text("Aquarium Connecté - " + sessionStorage.getItem('view'));
            $("#styleDynamique").attr("href", "templates/" + sessionStorage.getItem('view') + "/" + sessionStorage.getItem('view') + ".css")
        }
    </script>
</body>

</html>