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
if(isset($data->machine_id) && isset($data->branch_id) && isset($data->technician_id)&&isset($data->brand_id)
 && isset($data->status) && isset($data->venue)&&isset($data->cur_branch) && isset($data->ispart_replaced)){
    // CHECK DATA VALUE IS EMPTY OR NOT
    if(!empty($data->machine_id) && !empty($data->branch_id) && !empty($data->technician_id)&&!empty($data->brand_id) && !empty($data->status) && !empty($data->venue)
        &&!empty($data->cur_branch) && !empty($data->ispart_replaced)){
         $machine_id = $data->machine_id;
        $check_maintenance = "SELECT * FROM `maintenance` WHERE machine_id=:machine_id and date_added = CURDATE()";
        $check_maintenance_stmt = $conn->prepare($check_maintenance);
        $check_maintenance_stmt->bindValue(':machine_id', $machine_id,PDO::PARAM_INT);
        $check_maintenance_stmt->execute();

         if($check_maintenance_stmt->rowCount() > 0){
             $msg['code'] = 201;
            $msg['message'] = 'Maintenance records on this machine for the day is already taken';
        }else{
        $insert_query = "INSERT INTO `maintenance` (machine_id,branch_id,technician_id,brand_id,problem_statement,status,venue,part_replaced,date_added,ispart_replaced, cur_branch,recommendation) VALUES (:machine_id,:branch_id,:technician_id,:brand_id,:problem_statement,:status,:venue,:part_replaced,NOW(),:ispart_replaced,:cur_branch,:recommendation)";
        
        $insert_stmt = $conn->prepare($insert_query);
        // DATA BINDING
        $insert_stmt->bindValue(':machine_id', htmlspecialchars(strip_tags($data->machine_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':branch_id', htmlspecialchars(strip_tags($data->branch_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':technician_id', htmlspecialchars(strip_tags($data->technician_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':brand_id', htmlspecialchars(strip_tags($data->brand_id)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':problem_statement', htmlspecialchars(strip_tags($data->problem_statement)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':status', htmlspecialchars(strip_tags($data->status)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':venue', htmlspecialchars(strip_tags($data->venue)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':cur_branch', htmlspecialchars(strip_tags($data->cur_branch)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':part_replaced', htmlspecialchars(strip_tags($data->part_replaced)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':ispart_replaced', htmlspecialchars(strip_tags($data->ispart_replaced)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':recommendation', htmlspecialchars(strip_tags($data->recommendation)),PDO::PARAM_STR);
        
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
        $msg['message'] = 'Oops! empty field detected. Please fill all the fields';
    }
}
else{
     $msg['code'] = 202;
    $msg['message'] = 'Please fill all the fields';
}
//ECHO DATA IN JSON FORMAT
echo  json_encode($msg);
?>