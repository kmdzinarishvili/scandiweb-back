<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');

    use App\Objects\Product as Product;
    use App\Config\Database as Database;
    
    $database= new Database();
    $db = $database->connect();
    $data = json_decode(file_get_contents("php://input"));
    //body should be an array of the skus
    $response=[];
    if (isset($data->skus)&&is_array($data->skus)) {
        $del = Product::massDelete($db, $data->skus);
        if ($del) {
            $response["status"]= 200;
            $resposne["data"]="";
            echo json_encode($response);
        } else {
            $response["status"]= 500;
            $resposne["data"]="";
            $response["errorMessage"]="Undetermined Error.";
        }
    } else {
        $response["status"]= 400;
        $resposne["data"]="";
        $response["errorMessage"]="Valid SKUs Missing.";
        echo json_encode($response);
    }
