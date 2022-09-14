<?php

namespace App\Models;

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($db, $attributes)
    {
        parent::__construct($db, $attributes);
        $this->type = 'furniture';
        $this->height=$attributes['height'];
        $this->width=$attributes['width'];
        $this->length=$attributes['length'];
    }

    public function create()
    {
        $productSuccess = parent::create();
        if (!$productSuccess) {
            return false;
        }
        $sql = 'Insert into furniture
                    Set sku=:sku,
                      height=:height,
                      width=:width,
                      length=:length';
        $stmt = $this->conn->prepare($sql);

        $sku=htmlspecialchars(strip_tags($this->sku));
        $height=htmlspecialchars(strip_tags($this->height));
        $width=htmlspecialchars(strip_tags($this->width));
        $length=htmlspecialchars(strip_tags($this->length));

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':height', $height);
        $stmt->bindParam(':width', $width);
        $stmt->bindParam(':length', $length);

        if ($stmt->execute()) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }
}
