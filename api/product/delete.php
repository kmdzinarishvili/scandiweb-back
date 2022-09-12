<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');

    include_once dirname(__FILE__).'/../config/Database.php';
    include_once dirname(__FILE__).'/../objects/Product.php';
    
    $database= new Database();
    $db = $database->connect();
    $products = new Product($db);
    $data = json_decode(file_get_contents("php://input"));
    var_dump($data);
    // if (isset($data->skus)) {
    //     if ($products->massDelete($data->skus)) {
    //         echo "Records Deleted Succesfully";
    //     };
    // } else {
    //     echo "Valid SKUs Missing";
    // }
