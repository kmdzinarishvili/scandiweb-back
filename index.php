<?php
header("Access-Control-Allow-Methods: GET, POST,  DELETE, OPTIONS");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");

$method = $_SERVER['REQUEST_METHOD'];
require_once __DIR__.'/vendor/autoload.php';
use App\Controllers\ProductController as ProductController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));

$uriFound=false;
if (!empty($uri)&&$uri[0]==='products') {
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (count($uri)===1) {
                (new ProductController())->readAll();
                $uriFound=true;
                break;
            }
            break;
        case 'POST':
            if (count($uri)===2 && $uri[1]==='create') {
                (new ProductController())->create();
                $uriFound=true;
                break;
            }
            break;
        case 'DELETE':
            if (count($uri)===2 && $uri[1]==='massDelete') {
                (new ProductController())->massDelete();
                $uriFound=true;
                break;
            }
    }
}
if (!$uriFound) {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
}
