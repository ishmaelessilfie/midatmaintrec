<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// require '../config/database.php';
include_once 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
//CREATE MESSAGE ARRAY AND SET EMPTY
$msg['message'] = '';
// CHECK IF RECEIVED DATA FROM THE REQUEST
if(isset($data->machine_type)){
    // CHECK DATA VALUE IS EMPTY OR NOT
    if(!empty($data->machine_type)) {
        $machine_type = $data->machine_type;
        $check_machine_type = "SELECT * FROM `machine_type` WHERE machine_type=:machine_type";
        $check_machine_type_stmt = $conn->prepare($check_machine_type);
        $check_machine_type_stmt->bindValue(':machine_type', $machine_type,PDO::PARAM_STR);
        $check_machine_type_stmt->execute();
         if($check_machine_type_stmt->rowCount() > 0){
             $msg['code'] = 201;
            $msg['message'] = 'This machine type is already inserted';
        }else{
        $insert_query = "INSERT INTO `machine_type` (machine_type) VALUES (:machine_type)"; 
        $insert_stmt = $conn->prepare($insert_query);
        // DATA BINDING
        $insert_stmt->bindValue(':machine_type', htmlspecialchars(strip_tags($data->machine_type)),PDO::PARAM_STR);
        if($insert_stmt->execute()){
            $msg['code'] = 200;
            $msg['message'] = 'Data Inserted Successfully';
        }else{
            $msg['code']=201;
            $msg['message'] = 'Data not Inserted';
        } 
        }
    }else{
        $msg['code']=202;
        $msg['message'] = 'Oops! empty field detected. Please fill all the required fields';
    }
}
else{
    $msg['code']=202;
    $msg['message'] = 'Please fill all the fields | branch_name';
}
//ECHO DATA IN JSON FORMAT
echo  json_encode($msg);
?>