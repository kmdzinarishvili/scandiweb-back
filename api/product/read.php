<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    use App\Objects\Product as Product;
    use App\Config\Database as Database;

    $database= new Database();
    $db = $database->connect();
    $results = Product::readAll($db, "products");
    if (!empty($results)) {
        $response["status"]= 200;
        $response["data"]=$results;
        echo json_encode($response);
    } else {
        $response["status"]= 404;
        $resposne["data"]="";
        $response["errorMessage"]="Request successful but no data found";
        echo json_encode($response);
    }
