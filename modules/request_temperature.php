<?php

header('Content-Type: application/json');

require '../config/Database.php';

$db = Database::connect();
$statement = $db->prepare('SELECT A.id, A.temperature, A.timestamp FROM inputraspberry as A ORDER BY id DESC LIMIT :lim');
$statement->bindValue('lim', $_GET['limite'], PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
Database::disconnect();

http_response_code(200);
echo json_encode($result);


?>
