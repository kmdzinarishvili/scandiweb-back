<?php

namespace App\Models;

class Book extends Product
{
    private $weight;

    public function __construct($db, $attributes)
    {
        parent::__construct($db, $attributes);
        $this->type='book';
        $this->weight = $attributes['weight'];
    }

    public function create()
    {
        $productSuccess = parent::create();
        if (!$productSuccess) {
            return false;
        }
        $sql = 'Insert into books
                    Set sku=:sku,
                      weight=:weight';
        $stmt = $this->conn->prepare($sql);

        $sku=htmlspecialchars(strip_tags($this->sku));
        $weight=htmlspecialchars(strip_tags($this->weight));

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':weight', $weight);

        if ($stmt->execute()) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }
}
