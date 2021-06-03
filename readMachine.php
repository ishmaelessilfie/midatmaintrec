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
    $machine_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
        'options' => [
            'default' => 'all_machine',
            'min_range' => 1
        ]
    ]);
}
else{
    $machine_id = 'all_machine';
}

// MAKE SQL QUERY
// IF GET POSTS ID, THEN SHOW POSTS BY ID OTHERWISE SHOW ALL POSTS
$sql = is_numeric($machine_id) ? "SELECT * FROM machines 
left join branch on branch.id = machines.branch_id 
left join brand on brand.id= machines.brand_id
left join machine_type on  machine_type.id = machines.machine_type_id WHERE machines.id='$machine_id'" : "SELECT  machines.id,  serial_number,branch_name,brand_name,machine_type,zone,
 brand.id as brandid, machine_type.id as typeid, branch.id as branchid from machines
left join branch on branch.id = machines.branch_id 
left join brand on brand.id= machines.brand_id
left join machine_type on  machine_type.id = machines.machine_type_id"; 

$stmt = $conn->prepare($sql);

$stmt->execute();

//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $machine_array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($machine_array,$row);
        // PUSH POST DATA IN OUR $posts_array ARRAY
        // array_push($maintenance_array, $row);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    echo json_encode($machine_array);
 

}
else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['message'=>'No post found']);
}
?>