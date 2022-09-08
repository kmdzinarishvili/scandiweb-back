<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');
    include_once dirname(__FILE__).'/../../db/Database.php';
    include_once dirname(__FILE__).'/../../controllers/DVD.php';
    include_once dirname(__FILE__).'/../../controllers/Furniture.php';
    include_once dirname(__FILE__).'/../../controllers/Book.php';
    include_once dirname(__FILE__).'/../../controllers/Product.php';
    $database= new Database();
    $db = $database->connect();
    $product;
    $data = json_decode(file_get_contents("php://input"));
    if (empty($data)) {
        echo "Empty data";
    } else {
        if (property_exists($data, "sku")&&
        property_exists($data, "name")&&
        property_exists($data, "price")&&
        property_exists($data, "type")) {
            $sku = $data->sku;
            $name = $data->name;
            $price =  $data->price;
            $type = $data->type;
            unset($data->sku);
            unset($data->name);
            unset($data->price);
            unset($data->type);
            if ($type==="dvd") {
                $product=new DVD($db);
            } elseif ($type==="furniture") {
                $product= new Furniture($db);
            } elseif ($type==="book") {
                $product= new Book($db);
            }
            if (($type==="dvd"&&
                 property_exists($data, "size"))||
                 ($type==="furniture"&&
                 property_exists($data, "height")&&
                 property_exists($data, "width")&&
                 property_exists($data, "length"))||
                 ($type==="book"&&
                 property_exists($data, "weight"))) {
                $created = $product->create(
                    $sku,
                    $name,
                    $price,
                    $type,
                    $data
                );
                if ($created) {
                    echo "creation success";
                } else {
                    echo "failed creation";
                }
            } else {
                echo "Invalid specific product data";
            }
        } else {
            echo "Invalid product data";
        }
    }
