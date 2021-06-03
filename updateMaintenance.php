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
    $maintenance_id = $data->id;
    
    //GET POST BY ID FROM DATABASE
    $get_maintenance = "SELECT * FROM `maintenance` WHERE id=:maintenance_id";
    $get_stmt = $conn->prepare($get_maintenance);
    $get_stmt->bindValue(':maintenance_id', $maintenance_id,PDO::PARAM_INT);
    $get_stmt->execute();
    
    
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($get_stmt->rowCount() > 0){
        
        // FETCH POST FROM DATBASE 
        $row = $get_stmt->fetch(PDO::FETCH_ASSOC);
        
        // CHECK, IF NEW UPDATE REQUEST DATA IS AVAILABLE THEN SET IT OTHERWISE SET OLD DATA
        $machine_id = isset($data->machine_id) ? $data->machine_id : $row['machine_id'];
        $branch_id = isset($data->branch_id) ? $data->branch_id : $row['branch_id'];
        // $technician_id = isset($data->technician_id) ? $data->technician_id : $row['technician_id'];
        $brand_id = isset($data->brand_id) ? $data->brand_id : $row['brand_id'];
        $problem_statement = isset($data->problem_statement) ? $data->problem_statement : $row['problem_statement'];
        $date_added = isset($data->date_added) ? $data->date_added : $row['date_added'];
        $statuss = isset($data->statuss) ? $data->statuss : $row['statuss'];
        $ispart_replaced = isset($data->ispart_replaced) ? $data->ispart_replaced : $row['ispart_replaced'];
        $venue = isset($data->venue) ? $data->venue : $row['venue'];
        $cur_branch = isset($data->cur_branch) ? $data->cur_branch : $row['cur_branch'];
        $part_replaced = isset($data->part_replaced) ? $data->part_replaced : $row['part_replaced'];
        $recommendation = isset($data->recommendation) ? $data->recommendation : $row['recommendation'];
        $update_query = "UPDATE `maintenance` SET machine_id=:machine_id, branch_id=:branch_id,
   brand_id=:brand_id,  problem_statement=:problem_statement, statuss=:statuss,
   ispart_replaced=:ispart_replaced, venue=:venue, cur_branch=:cur_branch, part_replaced=:part_replaced, recommendation=:recommendation WHERE id = :id";
        
        $update_stmt = $conn->prepare($update_query);
        
        // DATA BINDING AND REMOVE SPECIAL CHARS AND REMOVE TAGS
        $update_stmt->bindValue(':machine_id', htmlspecialchars(strip_tags($data->machine_id)),PDO::PARAM_STR);
        // $insert_stmt->bindValue(':original_branch', htmlspecialchars(strip_tags($data->original_branch)),PDO::PARAM_STR);
        $update_stmt->bindValue(':branch_id', htmlspecialchars(strip_tags($data->branch_id)),PDO::PARAM_STR);
        // $update_stmt->bindValue(':technician_id', htmlspecialchars(strip_tags($data->technician_id)),PDO::PARAM_STR);
        $update_stmt->bindValue(':brand_id', htmlspecialchars(strip_tags($data->brand_id)),PDO::PARAM_STR);
        $update_stmt->bindValue(':problem_statement', htmlspecialchars(strip_tags($data->problem_statement)),PDO::PARAM_STR);
        $update_stmt->bindValue(':statuss', htmlspecialchars(strip_tags($data->statuss)),PDO::PARAM_STR);
        $update_stmt->bindValue(':venue', htmlspecialchars(strip_tags($data->venue)),PDO::PARAM_STR);
        $update_stmt->bindValue(':cur_branch', htmlspecialchars(strip_tags($data->cur_branch)),PDO::PARAM_STR);
        $update_stmt->bindValue(':part_replaced', htmlspecialchars(strip_tags($data->part_replaced)),PDO::PARAM_STR);
        $update_stmt->bindValue(':ispart_replaced', htmlspecialchars(strip_tags($data->ispart_replaced)),PDO::PARAM_STR);
        $update_stmt->bindValue(':recommendation', htmlspecialchars(strip_tags($data->recommendation)),PDO::PARAM_STR);


        $update_stmt->bindValue(':id', $maintenance_id,PDO::PARAM_INT);
        
        
        if($update_stmt->execute()){
            $msg['message'] = 'Data updated successfully';
        }else{
            $msg['message'] = 'data not updated';
        }   
        
    }
    else{
        $msg['message'] = 'Invlid ID';
    }  
    
    echo  json_encode($msg);
    
}
?>