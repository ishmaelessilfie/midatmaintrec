<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// INCLUDING DATABASE AND MAKING OBJECT
include_once 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));
//CHECKING, IF ID AVAILABLE ON $data
if(isset($data->id)){
    $msg['message'] = '';
    
    $maintenance_id = $data->id;
    $check_maintenance = "SELECT * FROM `maintenance` WHERE id=:maintenance_id";
    $check_maintenance_stmt = $conn->prepare($check_maintenance);
    $check_maintenance_stmt->bindValue(':maintenance_id', $maintenance_id,PDO::PARAM_INT);
    $check_maintenance_stmt->execute();
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($check_maintenance_stmt->rowCount() > 0){
        //DELETE POST BY ID FROM DATABASE
        $delete_maintenance = "DELETE FROM `maintenance` WHERE id=:maintenance_id";
        $delete_maintenance_stmt = $conn->prepare($delete_maintenance);
        $delete_maintenance_stmt->bindValue(':maintenance_id', $maintenance_id,PDO::PARAM_INT);
        if($delete_maintenance_stmt->execute()){
            $msg['message'] = 'Post Deleted Successfully';
        }else{
            $msg['message'] = 'Post Not Deleted';
        }
        
    }else{
        $msg['message'] = 'Invlid ID';
    }
    // ECHO MESSAGE IN JSON FORMAT
    echo  json_encode($msg); 
}
?>