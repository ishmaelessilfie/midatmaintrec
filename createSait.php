<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// INCLUDING DATABASE AND MAKING OBJECT
require 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
//CREATE MESSAGE ARRAY AND SET EMPTY
$msg['message'] = '';

// CHECK IF RECEIVED DATA FROM THE REQUEST
if(isset($data->machine_id) && isset($data->branch_id) &&isset($data->brand_id) &&isset($data->cur_branch) ){
    // CHECK DATA VALUE IS EMPTY OR NOT
    if(!empty($data->machine_id) && !empty($data->branch_id) &&!empty($data->brand_id) 
        &&!empty($data->cur_branch) ){
        $insert_query = "INSERT INTO `sait_repository` (sait_serial_number,original_branch_id,brand_id,problem_statement,date_recieved, branch_from_id,acknowlegement_status) VALUES (:machine_id,:branch_id,:brand_id,:problem_statement,NOW(),:cur_branch,'not')";
        
        $insert_stmt = $conn->prepare($insert_query);
        // DATA BINDING
        $insert_stmt->bindValue(':machine_id', htmlspecialchars(strip_tags($data->machine_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':branch_id', htmlspecialchars(strip_tags($data->branch_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':brand_id', htmlspecialchars(strip_tags($data->brand_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':problem_statement', htmlspecialchars(strip_tags($data->problem_statement)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':cur_branch', htmlspecialchars(strip_tags($data->cur_branch)),PDO::PARAM_STR);
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
     $msg['code'] = 202;
    $msg['message'] = 'Please fill all the fields';
}
//ECHO DATA IN JSON FORMAT
echo  json_encode($msg);
?>
       
