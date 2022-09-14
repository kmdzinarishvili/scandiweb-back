<?php
 namespace App\Config;

 use \PDO as PDO;

 class Database
 {
     private $host = 'remotemysql.com:3306';
     private $db_name = '6urnbojUNQ';
     private $username = '6urnbojUNQ';
     private $password = 'uUZ4ZO0vNr';
     private $conn;

     public function connect()
     {
         try {
             $this->conn = new PDO(
                 'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                 $this->username,
                 $this->password
             );
             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             echo 'Connection Error: '. $e->getMessage();
         }
         return $this->conn;
     }
 }
