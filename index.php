<?php
require_once __DIR__.'/vendor/autoload.php';
use App\Controllers\ProductController as ProductController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));
//for local
$uri=array_slice($uri, 2);

if (!empty($uri)&&$uri[0]==='products') {
    $uriFound=false;
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
    if (!$uriFound) {
        echo 'URI Not found';
    }
}
