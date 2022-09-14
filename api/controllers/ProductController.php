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
            $response=[];
    
            if (!empty($results)) {
                $response['status']= 200;
                $response['data']=$results;
                echo json_encode($response);
            } else {
                $response['status']= 404;
                $response['data']='';
                $response['errorMessage']='Request executed but no data found.';
                echo json_encode($response);
            }
        }


        public function massDelete()
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            header('Access-Control-Allow-Methods: DELETE');
            header('Access-Control-Allow-Headers:Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With ');
            $database= new Database();
            $db = $database->connect();
            $data = json_decode(file_get_contents('php://input'));
            //body should be an array of the skus
            $response=[];
            if (isset($data->skus)&&is_array($data->skus)) {
                $del = Product::massDelete($db, $data->skus);
                if ($del) {
                    $response['status']= 200;
                    $resposne['data']='';
                    echo json_encode($response);
                } else {
                    $response['status']= 500;
                    $response['data']='';
                    $response['errorMessage']='Undetermined Error.';
                }
            } else {
                $response['status']= 400;
                $response['data']='';
                $response['errorMessage']='Valid SKUs Missing.';
                echo json_encode($response);
            }
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
            $response=[];
        
            if (Product::validateInput($data)) {
                $className = ucfirst(strtolower($data['type']));
                $fullClassName ='App\\Models\\'.$className;
                $product = new $fullClassName($db, $data);
                $created = $product->create();
                $response['status']= 200;
                $response['data']='';
                echo json_encode($response);
            } else {
                $response['status']= 400;
                $response['data']='';
                $response['errorMessage']='Invalid input.';
                echo json_encode($response);
            }
        }
    }
