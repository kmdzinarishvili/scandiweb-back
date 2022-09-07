<?php

include_once dirname(__FILE__).'/Product.php';

class DVDs extends Products
{
    public $size;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->type = "dvd";
    }

    public function create_specific_table($sku, $data)
    {
        $sql = "Insert into dvds
                    Set sku=:sku,
                      size=:size";
        $stmt = $this->conn->prepare($sql);

        $sku=htmlspecialchars(strip_tags($sku));
        $name=htmlspecialchars(strip_tags($data->size));

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':size', $data->size);

        if ($stmt->execute()) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }
}
