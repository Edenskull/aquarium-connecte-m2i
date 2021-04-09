<?php

session_start();
if (!isset($_SESSION['view'])) {
    $_SESSION['view'] = "dashboard";
}

?>

<!DOCTYPE html>
<html lang="en">

<?php

include('templates/core/head.php');

?>

<body>

    <?php

        include('templates/'.$_SESSION['view'].'/'.$_SESSION['view'].'.php');

    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>