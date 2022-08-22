<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');


    include_once '../../db/Database.php';
    include_once '../../controllers/DVDs.php';
    include_once '../../controllers/Furniture.php';
    include_once '../../controllers/Books.php';
    include_once '../../controllers/Products.php';


    $database= new Database();
    $db = $database->connect();

    $products;

    $data = json_decode(file_get_contents("php://input"));

    if (empty($data)){
        echo "Empty data";
    }else{
        if(property_exists($data, "sku")&&
        property_exists($data, "name")&&
        property_exists($data, "price")&&
        property_exists($data, "type"))
        {
            $sku = $data->sku;
            $name = $data->name;
            $price =  $data->price;
            $type = $data->type;
        
            unset($data->sku);
            unset($data->name);
            unset($data->price);
            unset($data->type);
        
            if($type==="dvd"){
                $products=new DVDs($db);
            }else if($type==="furniture"){
                $products= new Furniture($db);
            }else if($type==="book"){
                $products= new Books($db);
            }
            
           if (($type==="dvd"&&
                property_exists($data, "size"))||
                ($type==="furniture"&&
                property_exists($data, "height")&&
                property_exists($data, "width")&&
                property_exists($data, "length"))||
                ($type==="book"&&
                property_exists($data, "weight"))){
                $created = $products->create($sku,$name,
                    $price,$type, $data );
                if($created){
                    echo "creation success";
                }else{
                    echo "failed creation";
                }
                
            }else{
                echo "Invalid specific product data";
            }
        }else{
            echo "Invalid product data";
        }
    }

?>
