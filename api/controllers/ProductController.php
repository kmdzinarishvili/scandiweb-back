<?php
    namespace App\Controllers;

    use App\Config\Database as Database;
    use App\Models\Product as Product;

    use App\Models\DVD as DVD;
    use App\Models\Furniture as Furniture;
    use App\Models\Book as Book;

    class ProductController
    {
        public function readAll()
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
    
            $database= new Database();
            $db = $database->connect();
            $results = Product::readAll($db);
    
            if (!empty($results)) {
                header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                echo json_encode($results);
            } else {
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
            }
        }


        public function massDelete()
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            header('Access-Control-Allow-Methods: DELETE');
            header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods');
            $database= new Database();
            $db = $database->connect();
            $data = json_decode(file_get_contents('php://input'));
            //body should be an array of the skus
            $response=[];
            echo "in mass delete";
            // if (isset($data->skus)&&is_array($data->skus)) {
            //     $del = Product::massDelete($db, $data->skus);
            //     if ($del) {
            //         header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
            //     } else {
            //         header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');
            //     }
            // } else {
            //     header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
            // }
        }

        //capitalization
        public function create()
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            header('Access-Control-Allow-Methods: DELETE');
            header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');
        
            $database= new Database();
            $db = $database->connect();
            $data = json_decode(file_get_contents('php://input'), true);
        
            if (Product::validateInput($data)) {
                $className = ucfirst(strtolower($data['type']));
                $fullClassName ='App\\Models\\'.$className;
                $product = new $fullClassName($db, $data);
                $created = $product->create();
                header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
            } else {
                header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
            }
        }
    }
