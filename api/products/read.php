<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../db/Database.php';
    include_once '../../controllers/Products.php';


    $database= new Database();
    $db = $database->connect();

    $products = new Products($db);
    $result = $products->read();

    ?>