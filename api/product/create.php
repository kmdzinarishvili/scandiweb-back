<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');

    use App\Config\Database as Database;
    use App\Objects\Product as Product;
    use App\Objects\DVD as DVD;
    use App\Objects\Furniture as Furniture;
    use App\Objects\Book as Book;

    $database= new Database();
    $db = $database->connect();
    $data = json_decode(file_get_contents("php://input"), true);
    $response=[];

    if (Product::validateInput($data)) {
        $className ="App\\Objects\\".$data['type'];
        $product = new $className($db, $data);
        $created = $product->create();
        $response["status"]= 200;
        $response["data"]="";
        echo json_encode($response);
    } else {
        $response["status"]= 400;
        $resposne["data"]="";
        $response["errorMessage"]="Invalid input";
        echo json_encode($response);
    }
