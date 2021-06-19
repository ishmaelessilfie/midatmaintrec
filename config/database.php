<?php
class Database{
    //Production
    private $db_host = 'https://remotemysql.com/phpmyadmin/sql.php';
    private $db_name = 'FaWMAUm8P4';
    private $db_username = 'FaWMAUm8P4';
    private $db_password = 'qoWSTBdwMP';

    //Development
    // private $db_host = 'localhost';
    // private $db_name = 'maintenance_db';
    // private $db_username = 'root';
    // private $db_password = '';
    
    public function dbConnection(){
        try{
            $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){
            echo "Connection error ".$e->getMessage(); 
            exit;
        } 
    }
}
 
//     private $db_host = 'localhost:3306';
//     private $db_name = 'icampsoe_maintenance';
//     private $db_username = 'icampsoe_midatin';
//     private $db_password = '20AlexIcamp@!';
?>
