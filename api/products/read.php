<?php

//add autoloader
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once dirname(__FILE__).'/../../db/Database.php';
include_once dirname(__FILE__).'/../../controllers/Product.php';
$database= new Database();
$db = $database->connect();
$product = new Product($db);
$result = $product->read();
