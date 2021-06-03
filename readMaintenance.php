<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// INCLUDING DATABASE AND MAKING OBJECT
// require '../config/database.php';
include_once 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();


// CHECK GET ID PARAMETER OR NOT
if(isset($_GET['id']))
{
    //IF HAS ID PARAMETER
    $maintenance_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
        'options' => [
            'default' => 'all_maintenance',
            'min_range' => 1
        ]
    ]);
}
else{
    $maintenance_id = 'all_maintenance';
}

// MAKE SQL QUERY
// IF GET POSTS ID, THEN SHOW POSTS BY ID OTHERWISE SHOW ALL POSTS
$sql = is_numeric($maintenance_id) ? "SELECT *, maintenance.id as maintid from maintenance
                     left join machines on machines.id = maintenance.machine_id 
                     left join brand on brand.id = machines.brand_id 
                     left join branch on branch.id=maintenance.branch_id 
                     left join technician on technician.id = maintenance.technician_id 
                     left join machine_type on machine_type.id = machines.machine_type_id WHERE maintenance.id='$maintenance_id' " : "SELECT maintenance.id,date_added,technician.id as technicianid,problem_statement,part_replaced,ispart_replaced,machine_id,venue,recommendation,maintenance.branch_id,maintenance.brand_id,maintenance.machine_id,machine_type,status,cur_branch,serial_number,machine_type_id,zone,branch_name,brand_name,name,machine_type from maintenance 
            left join machines on machines.id = maintenance.machine_id
            left join brand on brand.id = machines.brand_id 
            left join branch on branch.id=maintenance.branch_id 
            left join technician on technician.id = maintenance.technician_id 
            left join machine_type on machine_type.id = machines.machine_type_id "; 

$stmt = $conn->prepare($sql);

$stmt->execute();

//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $maintenance_array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($maintenance_array,$row);
        // PUSH POST DATA IN OUR $posts_array ARRAY
        // array_push($maintenance_array, $row);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    echo json_encode($maintenance_array);
 

}
else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['message'=>'No post found']);
}
?>