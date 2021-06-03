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
    $id = $data->id;
    
    //GET POST BY ID FROM DATABASE
    $get_sait = "SELECT * FROM sait_repository WHERE id=:id";
    $get_stmt = $conn->prepare($get_sait);
    $get_stmt->bindValue(':id', $id,PDO::PARAM_INT);
    $get_stmt->execute();
    
    
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($get_stmt->rowCount() > 0){
        
        // FETCH POST FROM DATBASE 
        $row = $get_stmt->fetch(PDO::FETCH_ASSOC);
        
        // CHECK, IF NEW UPDATE REQUEST DATA IS AVAILABLE THEN SET IT OTHERWISE SET OLD DATA
        $acknowlegement_status = isset($data->acknowlegement_status) ? $data->acknowlegement_status : $row['acknowlegement_status'];
        $problem_statement = isset($data->problem_statement) ? $data->problem_statement : $row['problem_statement'];
        $ispart_replaced = isset($data->ispart_replaced) ? $data->ispart_replaced : $row['ispart_replaced'];
        $part_replaced = isset($data->part_replaced) ? $data->part_replaced : $row['part_replaced'];
        $statuss = isset($data->statuss) ? $data->statuss : $row['statuss'];
        $recommendation = isset($data->recommendation) ? $data->recommendation : $row['recommendation'];
        $technician = isset($data->technician) ? $data->technician : $row['technician'];
        $tech_date = isset($data->tech_date) ? $data->tech_date : $row['tech_date'];

        $update_query = "UPDATE sait_repository SET acknowlegement_status = :acknowlegement_status,problem_statement=:problem_statement,ispart_replaced=:ispart_replaced,part_replaced=:part_replaced,statuss=:statuss,recommendation=:recommendation, technician= :technician, tech_date=:tech_date WHERE id = :id";
        
        $update_stmt = $conn->prepare($update_query);
        
        // DATA BINDING AND REMOVE SPECIAL CHARS AND REMOVE TAGS
        $update_stmt->bindValue(':acknowlegement_status', htmlspecialchars(strip_tags($acknowlegement_status)),PDO::PARAM_STR);
        $update_stmt->bindValue(':problem_statement', htmlspecialchars(strip_tags($problem_statement)),PDO::PARAM_STR);
        $update_stmt->bindValue(':ispart_replaced', htmlspecialchars(strip_tags($ispart_replaced)),PDO::PARAM_STR);
        $update_stmt->bindValue(':part_replaced', htmlspecialchars(strip_tags($part_replaced)),PDO::PARAM_STR);
        $update_stmt->bindValue(':statuss', htmlspecialchars(strip_tags($statuss)),PDO::PARAM_STR);
        $update_stmt->bindValue(':recommendation', htmlspecialchars(strip_tags($recommendation)),PDO::PARAM_STR);
        $update_stmt->bindValue(':technician', htmlspecialchars(strip_tags($technician)),PDO::PARAM_STR);
        $update_stmt->bindValue(':tech_date', htmlspecialchars(strip_tags($tech_date)),PDO::PARAM_STR);



        
        $update_stmt->bindValue(':id', $id,PDO::PARAM_INT);
        
        
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