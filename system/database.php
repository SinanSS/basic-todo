<?php
require_once __DIR__ . '/config.php';

try {

    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET NAMES ' . DB_CHARSET);

} catch (PDOException $e) {
    die($e->getMessage());
}

@$data = $_GET['data'];
switch ($data) {
    case 'database':
        $get = $db->prepare("SELECT * FROM todos");
        $get->execute();
        $row = $get->fetch(PDO::FETCH_OBJ);
        echo $row->todo_name;
        break;
}