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
    //body should be an array of the skus
    $response=[];
    if (isset($data->skus)&&$products->massDelete($data->skus)) {
        $response["status"]= 200;
        $resposne["data"]="";
        echo $response;
    } else {
        $response["status"]= 400;
        $resposne["data"]="";
        $response["errorMessage"]="Valid SKUs Missing";
        echo $response;
    }
