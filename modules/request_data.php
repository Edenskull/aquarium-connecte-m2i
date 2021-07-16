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

function checkAccess() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $statement = $db->prepare('SELECT * FROM `aquarium-user` WHERE id_aquarium = :idAqua AND id_user = :idUser');
    $statement->bindValue('idAqua', $aquaId, PDO::PARAM_INT);
    $statement->bindValue('idUser', $_SESSION['id'], PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if(count($result) > 0) {
        $response = array(
            "message" => "Access to current aquarium."
        );
        http_response_code(200);
        echo json_encode($response);
    } else {
        $response = array(
            "message" => "Forbidden access to current aquarium."
        );
        http_response_code(403);
        echo json_encode($response);
    }
}

function getLastData() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $userId = $_SESSION['id'];
    $statement = $db->prepare('SELECT D.ph, D.temperature, D.humidite, D.timestamp FROM data as D, `aquarium-data` as AD, `aquarium-user` as AU WHERE D.id = AD.id_data AND AD.id_aquarium = :aquaId AND AU.id_aquarium = :aquaId2 AND AU.id_user = :userId ORDER BY D.id DESC LIMIT 1');
    $statement->bindValue('aquaId', $aquaId, PDO::PARAM_INT);
    $statement->bindValue('aquaId2', $aquaId, PDO::PARAM_INT);
    $statement->bindValue('userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    http_response_code(200);
    echo json_encode($result);
}

function getLastTenData() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $userId = $_SESSION['id'];
    $statement = $db->prepare('SELECT D.ph, D.temperature, D.humidite, D.timestamp FROM data as D, `aquarium-data` as AD, `aquarium-user` as AU WHERE D.id = AD.id_data AND AD.id_aquarium = :aquaId AND AU.id_aquarium = :aquaId2 AND AU.id_user = :userId ORDER BY D.id DESC LIMIT 10');
    $statement->bindValue('aquaId', $aquaId, PDO::PARAM_INT);
    $statement->bindValue('aquaId2', $aquaId, PDO::PARAM_INT);
    $statement->bindValue('userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    http_response_code(200);
    echo json_encode($result);
}

function addAqua() {
    $db = Database::connect();
    $aquaName = $_POST['aquaName'];
    $statement = $db->prepare('INSERT INTO aquarium(name) VALUES (:name)');
    $statement->bindValue('name', $aquaName, PDO::PARAM_STR);
    $statement->execute();
    $statement = $db->prepare('SELECT id FROM aquarium ORDER BY id DESC LIMIT 1');
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $statement = $db->prepare('INSERT INTO `aquarium-user`(id_aquarium, id_user) VALUES (:idAqua, :idUser)');
    $statement->bindValue('idAqua', $result['id'], PDO::PARAM_INT);
    $statement->bindValue('idUser', $_SESSION['id'], PDO::PARAM_INT);
    $statement->execute();
    Database::disconnect();
    $response = array(
        "message" => "Aquarium créé."
    );
    http_response_code(200);
    echo json_encode($response);
}

function addLight() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $lightName = $_POST['lightName'];
    $statement = $db->prepare('INSERT INTO light(name, status) VALUES (:name, :status)');
    $statement->bindValue('name', $lightName, PDO::PARAM_STR);
    $statement->bindValue('status', false, PDO::PARAM_BOOL);
    $statement->execute();
    $statement = $db->prepare('SELECT id FROM light ORDER BY id DESC LIMIT 1');
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $statement = $db->prepare('INSERT INTO `aquarium-config`(id_aquarium, id_foreign, type) VALUES (:idAqua, :idFor, :type)');
    $statement->bindValue('idAqua', $aquaId, PDO::PARAM_INT);
    $statement->bindValue('idFor', $result['id'], PDO::PARAM_INT);
    $statement->bindValue('type', "Light", PDO::PARAM_STR);
    $statement->execute();
    Database::disconnect();
    $response = array(
        "message" => "Lumière créée."
    );
    http_response_code(200);
    echo json_encode($response);
}

function getLights() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $statement = $db->prepare("SELECT L.id, L.name, L.status FROM light as L, `aquarium-config` as AC WHERE AC.id_foreign = L.id AND AC.id_aquarium = :idAqua AND AC.type = 'Light'");
    $statement->bindValue('idAqua', $aquaId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    http_response_code(200);
    echo json_encode($result);
}

function updateLight() {
    $db = Database::connect();
    $lightId = $_POST['lightId'];
    $status = $_POST['status'];
    if($status == "On") {
        $status = true;
    } else {
        $status = false;
    }
    $statement = $db->prepare("UPDATE light SET status = :state WHERE id = :lightId");
    $statement->bindValue('lightId', $lightId, PDO::PARAM_INT);
    $statement->bindValue('state', $status, PDO::PARAM_BOOL);
    $statement->execute();
    Database::disconnect();
    $response = array(
        "message" => "Lumière mise à jour."
    );
    http_response_code(200);
    echo json_encode($response);
}

function addFood() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $foodName = $_POST['foodName'];
    $statement = $db->prepare('INSERT INTO food(name, status) VALUES (:name, :status)');
    $statement->bindValue('name', $foodName, PDO::PARAM_STR);
    $statement->bindValue('status', false, PDO::PARAM_BOOL);
    $statement->execute();
    $statement = $db->prepare('SELECT id FROM food ORDER BY id DESC LIMIT 1');
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $statement = $db->prepare('INSERT INTO `aquarium-config`(id_aquarium, id_foreign, type) VALUES (:idAqua, :idFor, :type)');
    $statement->bindValue('idAqua', $aquaId, PDO::PARAM_INT);
    $statement->bindValue('idFor', $result['id'], PDO::PARAM_INT);
    $statement->bindValue('type', "Food", PDO::PARAM_STR);
    $statement->execute();
    Database::disconnect();
    $response = array(
        "message" => "Distributeur créé."
    );
    http_response_code(200);
    echo json_encode($response);
}

function getFoods() {
    $db = Database::connect();
    $aquaId = $_POST['aquaId'];
    $statement = $db->prepare("SELECT F.id, F.name, F.status FROM food as F, `aquarium-config` as AC WHERE AC.id_foreign = F.id AND AC.id_aquarium = :idAqua AND AC.type = 'Food'");
    $statement->bindValue('idAqua', $aquaId, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();
    http_response_code(200);
    echo json_encode($result);
}

function updateFood() {
    $db = Database::connect();
    $foodId = $_POST['foodId'];
    $status = $_POST['status'];
    if($status == "On") {
        $status = true;
    } else {
        $status = false;
    }
    $statement = $db->prepare("UPDATE food SET status = :state WHERE id = :foodId");
    $statement->bindValue('foodId', $foodId, PDO::PARAM_INT);
    $statement->bindValue('state', $status, PDO::PARAM_BOOL);
    $statement->execute();
    Database::disconnect();
    $response = array(
        "message" => "Distributeur mis à jour."
    );
    http_response_code(200);
    echo json_encode($response);
}

if($_POST['mode'] == "aquarium") {
    getAllAquarium();
} else if($_POST['mode'] == "getlastdata") {
    getLastData();
} else if($_POST['mode'] == "getlasttendata") {
    getLastTenData();
} else if($_POST['mode'] == "addLight") {
    addLight();
} else if($_POST['mode'] == "getLights") {
    getLights();
} else if($_POST['mode'] == "updateLight") {
    updateLight();
} else if($_POST['mode'] == "addFood") {
    addFood();
} else if($_POST['mode'] == "getFoods") {
    getFoods();
} else if($_POST['mode'] == "updateFood") {
    updateFood();
} else if($_POST['mode'] == "addAqua") {
    addAqua();
} else if($_POST['mode'] == "checkAccess") {
    checkAccess();
}

?>
