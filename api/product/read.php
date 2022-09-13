<?php

//add autoloader
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require 'vendor/autoload.php';
// namespace Config\Database;

// namespace Object\Product;

include_once dirname(__FILE__).'/../config/Database.php';
include_once dirname(__FILE__).'/../objects/Product.php';
$database= new Database();
$db = $database->connect();
$product = new Product($db);
$result = $product->read();

if (!empty($result)) {
    $response["status"]= 200;
    $resposne["data"]=$result;
    echo $response;
} else {
    $response["status"]= 204;
    $resposne["data"]="";
    $response["errorMessage"]="Request successful but no data found";
    echo $response;
}
