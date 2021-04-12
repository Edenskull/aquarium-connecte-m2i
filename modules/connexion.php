<?php

session_start();
header('Content-Type: application/json');
require '../config/Database.php';


function connect() {
    $db = Database::connect();
    $usr = $_POST['username'];
    $pwd = $_POST['pwd'];
    $statement = $db->prepare('SELECT * FROM user WHERE username = :usr');
    $statement->bindValue('usr', $usr, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if(empty($result)) {
        http_response_code(401);
        $response = array(
            "message" => "Username or password invalid.",
            "statusCode" => 401
        );
        echo json_encode($response);
    } else {
        if(password_verify($pwd, $result['password'])) {
            http_response_code(200);
            $_SESSION['username'] = $usr;
            $response = array(
                "message" => "Connected",
                "statusCode" => "200"
            );
            echo json_encode($response);
        } else {
            http_response_code(401);
            $response = array(
                "message" => "Username or password invalid.",
                "statusCode" => 401
            );
            echo json_encode($response);
        }
    }
}

function signin() {
    $db = Database::connect();
    $usr = $_POST['username'];
    $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
    try {
        $statement = $db->prepare('INSERT INTO user(username, password) VALUES (:usr, :pwd)');
        $statement->bindValue('usr', $usr, PDO::PARAM_STR);
        $statement->bindValue('pwd', $pwd, PDO::PARAM_STR);
        $statement->execute();
        $response = array(
            "message" => "Account created now you can login.",
            "statusCode" => 200
        );
        http_response_code(200);
        echo json_encode($response);
    } catch (PDOException $e) {
        $response = array(
            "message" => $e->getMessage(),
            "statusCode" => 409
        );
        http_response_code(409);
        echo json_encode($response);
    }
}

function disconnect() {
    session_destroy();
    http_response_code(200);
    $response = array(
        "message" => "Session cleared. Disconnected.",
        "statusCode" => 200
    );
    echo json_encode($response);
}

if($_POST['mode'] == "connect") {
    connect();
} else if($_POST['mode'] == "signin") {
    signin();
} else {
    disconnect();
}

?>
