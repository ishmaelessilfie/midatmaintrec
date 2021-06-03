<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
//CREATE MESSAGE ARRAY AND SET EMPTY
$msg['message'] = '';
// CHECK IF RECEIVED DATA FROM THE REQUEST
if(isset($data->serial_number) && isset($data->branch_id) && isset($data->brand_id)&& isset($data->machine_type_id)){
    // CHECK DATA VALUE IS EMPTY OR NOT
    if(!empty($data->serial_number) && !empty($data->branch_id) && !empty($data->brand_id) && !empty($data->machine_type_id)){
        $serial_number = $data->serial_number;
        $check_machine = "SELECT * FROM `machines` WHERE serial_number=:serial_number";
        $check_machine_stmt = $conn->prepare($check_machine);
        $check_machine_stmt->bindValue(':serial_number', $serial_number,PDO::PARAM_STR);
        $check_machine_stmt->execute();
         if($check_machine_stmt->rowCount() > 0){
             $msg['code'] = 201;
            $msg['message'] = 'This Machine is already inserted';
        }else{
        $insert_query = "INSERT INTO `machines` (serial_number,branch_id,brand_id,machine_type_id,created_on,zone) VALUES (:serial_number,:branch_id,:brand_id,:type,CURDATE(),:zone)";
        $insert_stmt = $conn->prepare($insert_query);
        // DATA BINDING
        $insert_stmt->bindValue(':serial_number', htmlspecialchars(strip_tags($data->serial_number)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':branch_id', htmlspecialchars(strip_tags($data->branch_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':brand_id', htmlspecialchars(strip_tags($data->brand_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':type', htmlspecialchars(strip_tags($data->machine_type_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':zone', htmlspecialchars(strip_tags($data->zone)),PDO::PARAM_STR);
        if($insert_stmt->execute()){
            $msg['code'] = 200;
            $msg['message'] = 'Data Inserted Successfully';
        }else{
            $msg['code'] = 201;
            $msg['message'] = 'Data not Inserted';
        } 
    }
}
    else{
        $msg['code']=202;
        $msg['message'] = 'Oops! empty field detected. Please fill all the fields';
    }
}
else{
    $msg['code']=202;
    $msg['message'] = 'Please fill all the fields | title, body, author';
}
//ECHO DATA IN JSON FORMAT
echo  json_encode($msg);
?>