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
    $machine_type_id = $data->id;
    $check_machine_type = "SELECT * FROM `machine_type` WHERE id=:machine_type_id";
    $check_machine_type_stmt = $conn->prepare($check_machine_type);
    $check_machine_type_stmt->bindValue(':machine_type_id', $machine_type_id,PDO::PARAM_INT);
    $check_machine_type_stmt->execute();
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($check_machine_type_stmt->rowCount() > 0){
        //DELETE POST BY ID FROM DATABASE
        $delete_machine_type = "DELETE FROM `machine_type` WHERE id=:machine_type_id";
        $delete_machine_type_stmt = $conn->prepare($delete_machine_type);
        $delete_machine_type_stmt->bindValue(':machine_type_id', $machine_type_id,PDO::PARAM_INT);
        if($delete_machine_type_stmt->execute()){
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