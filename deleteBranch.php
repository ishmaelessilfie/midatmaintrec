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
    $branch_id = $data->id;
    $check_branch = "SELECT * FROM `branch` WHERE id=:branch_id";
    $check_branch_stmt = $conn->prepare($check_branch);
    $check_branch_stmt->bindValue(':branch_id', $branch_id,PDO::PARAM_INT);
    $check_branch_stmt->execute();
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($check_branch_stmt->rowCount() > 0){ 
        //DELETE POST BY ID FROM DATABASE
        $delete_branch = "DELETE FROM `branch` WHERE id=:branch_id";
        $delete_branch_stmt = $conn->prepare($delete_branch);
        $delete_branch_stmt->bindValue(':branch_id', $branch_id,PDO::PARAM_INT);
        if($delete_branch_stmt->execute()){
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