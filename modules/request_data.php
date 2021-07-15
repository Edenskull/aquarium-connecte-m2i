<?php

session_start();
header('Content-Type: application/json');
require '../config/Database.php';


function getAllAquarium() {
    $db = Database::connect();
    $userId = $_SESSION['id'];
    $statement = $db->prepare('SELECT A.name, A.id FROM aquarium as A, `aquarium-user` as AU WHERE A.id = AU.id_aquarium AND AU.id_user = :userId');
    $statement->bindValue('userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    http_response_code(200);
    echo json_encode($result);
}

function getLastData() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $statement = $db->prepare('SELECT D.ph, D.temperature, D.humidite, D.timestamp FROM data as D, `aquarium-data` as AD WHERE D.id = AD.id_data AND AD.id_aquarium = :aquaId ORDER BY D.id DESC LIMIT 1');
    $statement->bindValue('aquaId', $aquaId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    http_response_code(200);
    echo json_encode($result);
}

function getLastTenData() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $statement = $db->prepare('SELECT D.ph, D.temperature, D.humidite, D.timestamp FROM data as D, `aquarium-data` as AD WHERE D.id = AD.id_data AND AD.id_aquarium = :aquaId ORDER BY D.id DESC LIMIT 10');
    $statement->bindValue('aquaId', $aquaId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    http_response_code(200);
    echo json_encode($result);
}

if($_POST['mode'] == "aquarium") {
    getAllAquarium();
} else if($_POST['mode'] == "getlastdata") {
    getLastData();
} else if($_POST['mode'] == "getlasttendata") {
    getLastTenData();
}

?>
