<?php

namespace App\Modles;

class DVD extends Product
{
    private $size;

    public function __construct($db, $attributes)
    {
        parent::__construct($db, $attributes);
        $this->type = "dvd";
        $this->size=$attributes['size'];
    }

    public function create()
    {
        $productSuccess = parent::create($this);
        if (!$productSuccess) {
            return false;
        }
        $sql = "Insert into dvds
                    Set sku=:sku,
                      size=:size";
        $stmt = $this->conn->prepare($sql);
        $sku=htmlspecialchars(strip_tags($this->sku));
        $size=htmlspecialchars(strip_tags($this->size));
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':size', $size);

        if ($stmt->execute()) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }
}
