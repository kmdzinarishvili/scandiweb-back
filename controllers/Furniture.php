<?php
    include_once dirname(__FILE__).'/Products.php';

    class Furniture extends Products{
        public function __construct($db) {
            parent::__construct($db);
        }

        public function create_specific_table($sku, $data){
                $sql = "Insert into furniture
                    Set sku=:sku,
                      height=:height,
                      width=:width,
                      length=:length";
                $stmt = $this->conn->prepare($sql);
            
                $sku=htmlspecialchars(strip_tags($sku));
                $name=htmlspecialchars(strip_tags($data->height));
                $price=htmlspecialchars(strip_tags($data->width));
                $type=htmlspecialchars(strip_tags($data->length));
            
                $stmt->bindParam(':sku', $sku);
                $stmt->bindParam(':height', $data->height);
                $stmt->bindParam(':width', $data->width);
                $stmt->bindParam(':length', $data->length);
            
                if ($stmt->execute()){
                  return true;
                }else{
                  echo $stmt->error;
                  return false;
                }
        }

    }


  ?>