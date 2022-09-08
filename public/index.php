<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));


switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $req  = json_decode(file_get_contents("php://input"));
        include_once  dirname(__FILE__).'/../api/products/read.php';
        break;
    case 'POST':
        $req  = json_decode(file_get_contents("php://input"));
        include_once  dirname(__FILE__).'/../api/products/create.php';
        break;
    case 'DELETE':
        $req  = json_decode(file_get_contents("php://input"));
        include_once  dirname(__FILE__).'/../api/products/delete.php';
        break;
    default:
}
