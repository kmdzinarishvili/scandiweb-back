<?php

namespace App\Objects;

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($db, $attributes)
    {
        parent::__construct($db, $attributes);
        $this->type = "furniture";
        $this->height=$attributes['height'];
        $this->width=$attributes['width'];
        $this->length=$attributes['length'];
    }

    public function createSpecificTable($sku, $data)
    {
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

        if ($stmt->execute()) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }
}
