<?php

namespace App\Models;

use App\Config\Database as Database;

use \PDO;

abstract class Product
{
    protected static $table = 'products';
    protected $conn;

    const TYPES=array('dvds'=>['size'], 'furniture'=>['height', 'width', 'length'], 'books'=>['weight']);
    const ATTRIBUTES=array('sku','name','price','type');

    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($db, $attributes)
    {
        $this->conn = $db;
        $this->sku=$attributes['sku'];
        $this->name=$attributes['name'];
        $this->price=$attributes['price'];
        $this->type=$attributes['type'];
    }

    public static function readAll($conn)
    {
        $results=array();
        foreach (self::TYPES as $type=>$typeAttribute) {
            $sql = 'SELECT * FROM '.self::$table.
                    ' join '.$type.' on '
                    .self::$table.'.sku='.$type.'.sku';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $row = (object) $row;
                    array_push($results, $row);
                }
            }
        }
        function cmp($a, $b)
        {
            return strcmp($a->sku, $b->sku);
        }
        usort($results, function ($a, $b) {
            return strcmp($a->sku, $b->sku);
        });
        return ($results);
    }
   

    public static function validateInput($data)
    {
        foreach (self::ATTRIBUTES as $attribute) {
            if (!array_key_exists($attribute, $data)) {
                return false;
            }
        }
        $type = strtolower($data['type']);
        foreach (self::TYPES[$type]??self::TYPES[$type.'s'] as $attribute) {
            if (!array_key_exists($attribute, $data)) {
                return false;
            }
        }
        
        return true;
    }


    public function create()
    {
        $sql = 'Insert into '
                .self::$table.
                ' Set sku=:sku,
                name=:name,
                price=:price,
                type=:type';
        $stmt = $this->conn->prepare($sql);

        $sku=htmlspecialchars(strip_tags($this->sku));
        $name=htmlspecialchars(strip_tags($this->name));
        $price=htmlspecialchars(strip_tags($this->price));
        $type=htmlspecialchars(strip_tags($this->type));

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':type', $type);

        if ($stmt->execute()) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }

    public static function massDelete($db, $skus)
    {
        try {
            for ($i=0;$i<count($skus);$i++) {
                // on delete cascade for dvds, books, and furniture tables
                $sql = 'DELETE FROM '.self::$table.' WHERE sku=:sku';
                //prepare statement
                $stmt = $db->prepare($sql);
                //cleaning sku
                $sku=htmlspecialchars(strip_tags($skus[$i]));
                $stmt->bindParam(':sku', $sku);
                if (!$stmt->execute()) {
                    return false;
                }
            }
            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
