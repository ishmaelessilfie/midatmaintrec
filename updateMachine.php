<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));

//CHECKING, IF ID AVAILABLE ON $data
if(isset($data->id)){
    
    $msg['message'] = '';
    $machine_id = $data->id;
    
    //GET POST BY ID FROM DATABASE
    $get_machine = "SELECT * FROM machines WHERE id=:machine_id";
    $get_stmt = $conn->prepare($get_machine);
    $get_stmt->bindValue(':machine_id', $machine_id,PDO::PARAM_INT);
    $get_stmt->execute();
    //CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
    if($get_stmt->rowCount() > 0){
        // FETCH POST FROM DATBASE 
        $row = $get_stmt->fetch(PDO::FETCH_ASSOC);
        // CHECK, IF NEW UPDATE REQUEST DATA IS AVAILABLE THEN SET IT OTHERWISE SET OLD DATA
        $serial_number = isset($data->serial_number) ? $data->serial_number : $row['serial_number'];
        $branch_id = isset($data->branch_id) ? $data->branch_id : $row['branch_id'];
        $brand_id = isset($data->brand_id) ? $data->brand_id : $row['brand_id'];
        $machine_type_id = isset($data->machine_type_id) ? $data->machine_type_id : $row['type'];
        $zone = isset($data->zone) ? $data->zone : $row['zone'];
        $created_on = isset($data->created_on) ? $data->created_on : $row['created_on'];
        $update_query = "UPDATE machines SET serial_number = :serial_number, branch_id = :branch_id,
         brand_id = :brand_id, machine_type_id = :type, zone = :zone WHERE id = :id";
        $update_stmt = $conn->prepare($update_query);
        
        // DATA BINDING AND REMOVE SPECIAL CHARS AND REMOVE TAGS
        $update_stmt->bindValue(':serial_number', htmlspecialchars(strip_tags($data->serial_number)),PDO::PARAM_STR);
        $update_stmt->bindValue(':branch_id', htmlspecialchars(strip_tags($data->branch_id)),PDO::PARAM_STR);
        $update_stmt->bindValue(':brand_id', htmlspecialchars(strip_tags($data->brand_id)),PDO::PARAM_STR);
        $update_stmt->bindValue(':type', htmlspecialchars(strip_tags($data->machine_type_id)),PDO::PARAM_STR);
        $update_stmt->bindValue(':zone', htmlspecialchars(strip_tags($data->zone)),PDO::PARAM_STR);
        $update_stmt->bindValue(':id', $machine_id,PDO::PARAM_INT);
        
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