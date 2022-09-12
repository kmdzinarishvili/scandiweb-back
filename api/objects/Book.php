<?php

include_once dirname(__FILE__).'/Product.php';

class Book extends Product
{
    public $weight;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->type="book";
    }

    public function createSpecificTable($sku, $data)
    {
        $sql = "Insert into books
                    Set sku=:sku,
                      weight=:weight";
        $stmt = $this->conn->prepare($sql);

        $sku=htmlspecialchars(strip_tags($sku));
        $name=htmlspecialchars(strip_tags($data->weight));

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':weight', $data->weight);

        if ($stmt->execute()) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }
}
