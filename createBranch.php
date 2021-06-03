<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
//CREATE MESSAGE ARRAY AND SET EMPTY
$msg['message'] = '';
$code['code'] = '';
// CHECK IF RECEIVED DATA FROM THE REQUEST
if(isset($data->branch_name) ){
    // CHECK DATA VALUE IS EMPTY OR NOT
    if(!empty($data->branch_name)){
        $branch_name = $data->branch_name;

        $check_branch = "SELECT * FROM `branch` WHERE branch_name=:branch_name";
        $check_branch_stmt = $conn->prepare($check_branch);
        $check_branch_stmt->bindValue(':branch_name', $branch_name,PDO::PARAM_STR);
        $check_branch_stmt->execute();

         if($check_branch_stmt->rowCount() > 0){
             $msg['code'] = 201;
            $msg['message'] = 'This Branch is already inserted';
        }else{
        
        $insert_query = "INSERT INTO branch (branch_name,contact_info) VALUES (:branch_name,:contact_info)";
        
        $insert_stmt = $conn->prepare($insert_query);
        // DATA BINDING
        $insert_stmt->bindValue(':branch_name', htmlspecialchars(strip_tags($data->branch_name)),PDO::PARAM_STR);
        $insert_stmt->bindValue(':contact_info', htmlspecialchars(strip_tags($data->contact_info)),PDO::PARAM_STR);
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