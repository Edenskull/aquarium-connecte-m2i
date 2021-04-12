<?php

header('Content-Type: application/json');
require '../config/Database.php';


function getLastsTemperature(){
    $db = Database::connect();
    $statement = $db->prepare('SELECT A.id, A.temperature, A.timestamp FROM inputraspberry as A ORDER BY id DESC LIMIT :lim');
    $statement->bindValue('lim', $_GET['limite'], PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();

    http_response_code(200);
    echo json_encode($result);
}

function getCurrentTemperature(){
    $db = Database::connect();
    $statement = $db->prepare('SELECT A.id, A.temperature FROM inputraspberry as A ORDER BY id DESC LIMIT 1');
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    http_response_code(200);
    echo json_encode($result);
}

switch($_GET['call']) {
    case "1":
        getLastsTemperature();
        break;
    case "2":
        getCurrentTemperature();
        break;
    default:
        http_response_code(500);
        echo "la requete n'est pas valide";
}

?>
