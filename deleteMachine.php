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
    
    $machine_id = $data->id;
    
    $check_machine = "SELECT * FROM `machines` WHERE id=:machine_id";
    $check_machine_stmt = $conn->prepare($check_machine);
    $check_machine_stmt->bindValue(':machine_id', $machine_id,PDO::PARAM_INT);
    $check_machine_stmt->execute();
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($check_machine_stmt->rowCount() > 0){
        //DELETE POST BY ID FROM DATABASE
        $delete_machine = "DELETE FROM `machines` WHERE id=:machine_id";
        $delete_maintenance = "DELETE FROM `maintenance` WHERE machine_id=:machine_id";
        $delete_machine_stmt = $conn->prepare($delete_machine);
        $delete_maintenance_stmt = $conn->prepare($delete_maintenance);
        $delete_machine_stmt->bindValue(':machine_id', $machine_id,PDO::PARAM_INT);
        $delete_maintenance_stmt->bindValue(':machine_id', $machine_id,PDO::PARAM_INT);
        if($delete_maintenance_stmt->execute() && $delete_machine_stmt->execute()){
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