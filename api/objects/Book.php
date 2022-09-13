<?php

namespace App\Objects;

class Book extends Product
{
    private $weight;

    public function __construct($db, $attributes)
    {
        parent::__construct($db, $attributes);
        $this->type="book";
        $this->weight = $attributes['weight'];
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
