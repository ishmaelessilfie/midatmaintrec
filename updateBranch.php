<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// INCLUDING DATABASE AND MAKING OBJECT
// require '../config/database.php';
include_once 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));

//CHECKING, IF ID AVAILABLE ON $data
if(isset($data->id)){
    
    $msg['message'] = '';
    $branch_id = $data->id;
    
    //GET POST BY ID FROM DATABASE
    $get_branch = "SELECT * FROM branch WHERE id=:branch_id";
    $get_stmt = $conn->prepare($get_branch);
    $get_stmt->bindValue(':branch_id', $branch_id,PDO::PARAM_INT);
    $get_stmt->execute();
    
    
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($get_stmt->rowCount() > 0){
        
        // FETCH POST FROM DATBASE 
        $row = $get_stmt->fetch(PDO::FETCH_ASSOC);
        
        // CHECK, IF NEW UPDATE REQUEST DATA IS AVAILABLE THEN SET IT OTHERWISE SET OLD DATA
        $post_branch_name = isset($data->branch_name) ? $data->branch_name : $row['branch_name'];
        $post_contact_info = isset($data->contact_info) ? $data->contact_info : $row['contact_info'];
        
        $update_query = "UPDATE branch SET branch_name = :branch_name, contact_info = :contact_info WHERE id = :id";
        
        $update_stmt = $conn->prepare($update_query);
        
        // DATA BINDING AND REMOVE SPECIAL CHARS AND REMOVE TAGS
        $update_stmt->bindValue(':branch_name', htmlspecialchars(strip_tags($post_branch_name)),PDO::PARAM_STR);
        $update_stmt->bindValue(':contact_info', htmlspecialchars(strip_tags($post_contact_info)),PDO::PARAM_STR);
        
        $update_stmt->bindValue(':id', $branch_id,PDO::PARAM_INT);
        
        
        if($update_stmt->execute()){
            $msg['message'] = 'Data updated successfully';
        }else{
            $msg['message'] = 'data not updated';
        }   
        
    }
    else{
        $msg['message'] = 'Invlid ID';
    }  
    }
    echo  json_encode($msg);
    

?>