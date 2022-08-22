<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');
    
    include_once '../../db/Database.php';
    include_once '../../controllers/Products.php';
    include_once '../../controllers/Furniture.php';
    include_once '../../controllers/Books.php';
    include_once '../../controllers/DVDs.php';



    $database= new Database();
    $db = $database->connect();

    $products;

    $data = json_decode(file_get_contents("php://input"));
    $sku = $data->sku;
    $name = $data->name;
    $price =  $data->price;
    $type = $data->type;

    unset($data->sku);
    unset($data->name);
    unset($data->price);
    unset($data->type);

    if($type==="DVD"){
        $products===new DVDs($db);
    }else if($type==="Furniture"){
        $products= new Furniture($db);
    }else if($type==="Book"){
        $products= new Books($db);
    }

    $products->create($sku,$name,
        $price,$type, $data );


?>
