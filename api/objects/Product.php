<?php

namespace App\Objects;

use App\Objects\DVD as DVD;

use \PDO;

define('TYPES', array("dvds"=>["size"], "furniture"=>["height", "width", "length"], "books"=>["weight"]));

abstract class Product
{
    protected static $table = "products";
    protected $conn;

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

    public static function readAll($db)
    {
        $conn = $db;
        //add prepared statement
        $results=array();

        $sql ="";
        
        //add all rows
        foreach (TYPES as $type => $typeAttribute) {
            // var_dump($type, $typeAttribute);
    
            $sql .="SELECT ".Product::$table.".sku, name, price, type, ";
          
            foreach (TYPES as $key => $subTypeAttribute) {
                $additionalCondition="";
                $comma="";
                //checks if this attribute is part of current table
                if ($typeAttribute!=$subTypeAttribute) {
                    $additionalCondition=" NULL as ";
                }
                //adds to select statement. if this attribute is in this table
                //adds regularly, otherwise selects as null
                foreach ($subTypeAttribute as $attribute) {
                    $sql .=$additionalCondition.$attribute.", ";
                }
            }
            //removes last comma and adds space
            $sql = substr($sql, 0, -2)." ";
        
            //specifies which tables it is selecting from/joining
            $sql .="FROM "
                    .Product::$table." right join ".$type." on "
                    .Product::$table.".sku=".$type.".sku UNION ";
        }
        //removes last union
        $sql =trim($sql, "UNION ");
        //makes pseudo table from previously made sql statement
        //orders by sku
        $sql ="SELECT * FROM (". $sql.")prods ORDER BY sku";
        $result = $conn->query($sql);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $type ="App\\Objects\\".$row['type'];
            $object = new $type($db, $row);
            array_push($results, $object);
        }
        var_dump($results);

        return $results;
    }


    public function create($sku, $name, $price, $type, $other)
    {
        $sql = "Insert into ".$this->table.
        " Set sku=:sku,
          name=:name,
          price=:price,
          type=:type";
        $stmt = $this->conn->prepare($sql);

        $sku=htmlspecialchars(strip_tags($sku));
        $name=htmlspecialchars(strip_tags($name));
        $price=htmlspecialchars(strip_tags($price));
        $type=htmlspecialchars(strip_tags($type));

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':type', $type);

        if ($stmt->execute()&&$this->createSpecificTable($sku, $other)) {
            return true;
        } else {
            echo $stmt->error;
            return false;
        }
    }

 public function massDelete($skus)
 {
     try {
         for ($i=0;$i<count($skus);$i++) {
             // on delete cascade for dvds, books, and furniture tables
             $sql = "DELETE FROM ".$this->table." WHERE sku=:sku";
             //prepare statement
             $stmt = $this->conn->prepare($sql);
             //cleaning sku
             $sku=htmlspecialchars(strip_tags($skus[$i]));
             $stmt->bindParam(':sku', $sku);
             $stmt->execute();
         }
         return true;
     } catch(PDOException $e) {
         echo $e->getMessage();
         return false;
     }
 }
    public function createSpecificTable($sku, $data)
    {
    }
}
