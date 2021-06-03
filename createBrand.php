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

if(isset($data->brand_name) ){
    // CHECK DATA VALUE IS EMPTY OR NOT
    if(!empty($data->brand_name)){
        $brand_name = $data->brand_name;
        $check_brand = "SELECT * FROM `brand` WHERE brand_name=:brand_name";
        $check_brand_stmt = $conn->prepare($check_brand);
        $check_brand_stmt->bindValue(':brand_name', $brand_name,PDO::PARAM_STR);
        $check_brand_stmt->execute();
         if($check_brand_stmt->rowCount() > 0){
             $msg['code'] = 201;
            $msg['message'] = 'This Brand is already inserted';
        }else{
        $insert_query = "INSERT INTO `brand` (brand_name) VALUES (:brand_name)";
        $insert_stmt = $conn->prepare($insert_query);
        // DATA BINDING
        $insert_stmt->bindValue(':brand_name', htmlspecialchars(strip_tags($data->brand_name)),PDO::PARAM_STR);
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