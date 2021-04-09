<?php

require 'Database.php';

function example() {
    $id = 1;
    $db = Database::connect();
    $statement = $db->prepare('SELECT * FROM docs WHERE id = ?');
    $statement->execute(array($id));
    $result = $statement->fetch();
    Database::disconnect();
}

?>
