<?php
 class Database{
//DB params
    private $host = 'localhost';
    private $db_name = 'car_insurance';
    private $username = 'root';
    private $password = '';
    private $conn;

//DB Connect
public function connect(){
    $this->conn = null;

    try {       
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);   
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'Connection error: ' . $e->getMessage();
        // You might want to handle the error more gracefully here, e.g., log it or display a user-friendly message.
    }

    return $this->conn;
}


}