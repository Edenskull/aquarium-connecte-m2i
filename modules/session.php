<?php

session_start();
header('Content-Type: application/json');
require '../config/Database.php';


function login() {
    $db = Database::connect();
    $login = $_POST['login'];
    $password = $_POST['password'];
    $statement = $db->prepare('SELECT * FROM user WHERE login = :login');
    $statement->bindValue('login', $login, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if(empty($result)) {
        $response = array(
            "message" => "Username or password invalid."
        );
        http_response_code(401);
        echo json_encode($response);
    } else {
        if(password_verify($password, $result['password'])) {
            $_SESSION['username'] = $login;
            $_SESSION['email'] = $result['email'];
            $_SESSION['id'] = $result['id'];
            $response = array(
                "message" => "Connected"
            );
            http_response_code(200);
            echo json_encode($response);
        } else {
            $response = array(
                "message" => "Username or password invalid."
            );
            http_response_code(401);
            echo json_encode($response);
        }
    }
}

function register() {
    $db = Database::connect();
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    try {
        $statement = $db->prepare('INSERT INTO user(login, password, email) VALUES (:login, :password, :email)');
        $statement->bindValue('login', $login, PDO::PARAM_STR);
        $statement->bindValue('password', $password, PDO::PARAM_STR);
        $statement->bindValue('email', $email, PDO::PARAM_STR);
        $statement->execute();
        $response = array(
            "message" => "Account created. Now you can login."
        );
        http_response_code(200);
        echo json_encode($response);
    } catch (Exception $e) {
        $response = array(
            "message" => $e->getMessage()
        );
        http_response_code(409);
        echo json_encode($response);
    }
}

function disconnect() {
    session_destroy();
    $response = array(
        "message" => "Session cleared. Disconnected.",
    );
    http_response_code(200);
    echo json_encode($response);
}

function isConnected() {
    if(empty($_SESSION['username'])) {
        http_response_code(200);
        $response = array(
            "connected" => "false",
            "statusCode" => 200
        );
        echo json_encode($response);
    } else {
        http_response_code(200);
        $response = array(
            "connected" => "true",
            "statusCode" => 200
        );
        echo json_encode($response);
    }
}

if($_POST['mode'] == "login") {
    login();
} else if($_POST['mode'] == "register") {
    register();
} else if($_POST['mode'] == "isconnected") {
    isConnected();
} else {
    disconnect();
}

?>
