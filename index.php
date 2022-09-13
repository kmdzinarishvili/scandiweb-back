<?php
// require_once 'objects/Product.php';
// require_once 'objects/DVD.php';
// require_once 'objects/Furniture.php';
// require_once 'objects/Book.php';
// require_once 'config/Database.php';
// "Objects\\": "api/objects",
// "Config\\": "api/config",
// "Product\\": "api/product"
require_once __DIR__.'/vendor/autoload.php';
use App\Objects\Product as Product;
use App\Config\Database as Database;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));
//for local
$uri=array_slice($uri, 2);

if (!empty($uri)&&$uri[0]==="products") {
    $uriFound=false;
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (count($uri)===1) {
                $req  = json_decode(file_get_contents("php://input"));
                include_once  dirname(__FILE__).'/api/product/read.php';
                $uriFound=true;
                break;
            }
            break;
        case 'POST':
            if (count($uri)===2 && $uri[1]==="create") {
                // $req  = json_decode(file_get_contents("php://input"));
                include_once  dirname(__FILE__).'/api/product/create.php';
                $uriFound=true;
                break;
            }
            break;
        case 'DELETE':
            if (count($uri)===2 && $uri[1]==="massDelete") {
                // $req  = json_decode(file_get_contents("php://input"));
                include_once  dirname(__FILE__).'/api/product/delete.php';
                $uriFound=true;
                break;
            }
    }
    if (!$uriFound) {
        echo "URI Not found";
    }
}
