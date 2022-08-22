<?php
    include_once '../../db/Database.php';
    define('TYPES', array("dvds", "furniture", "books"));

 class Products {
  protected $conn;
  private $table = "products";


  

  public function __construct($db) {
    $this->conn = $db;
  }

  public  function read(){
      $results=array();
      foreach (TYPES as &$type){
        $sql = "SELECT * FROM ".$this->table.
                " join ".$type." 
                on ".$this->table.".sku=".$type.".sku";
        $result = $this->conn->query($sql);

      if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          array_push($results, $row);

        }
      }
    }
      echo json_encode($results);
    }
   

  public function create($sku,$name,$price,$type, $other ){
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

    if ($stmt->execute()&&$this->create_specific_table($sku, $other)){
      return true;
    }else{
      echo $stmt->error;
      return false;
    }

 }

 public function mass_delete($skus){
  try {
    for($i=0;$i<count($skus);$i++){
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
  public function create_specific_table($sku, $data){}
}
 
?>
