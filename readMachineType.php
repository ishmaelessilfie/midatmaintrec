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
    $machine_type_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
        'options' => [
            'default' => 'all_machine_type',
            'min_range' => 1
        ]
    ]);
}
else{
    $machine_type_id = 'all_machine_type';
}

// MAKE SQL QUERY
// IF GET POSTS ID, THEN SHOW POSTS BY ID OTHERWISE SHOW ALL POSTS
$sql = is_numeric($machine_type_id) ? "SELECT * FROM machine_type WHERE id='$machine_type_id'" : "SELECT * from machine_type"; 

$stmt = $conn->prepare($sql);

$stmt->execute();

//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $machine_type_array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($machine_type_array,$row);
        // PUSH POST DATA IN OUR $posts_array ARRAY
        // array_push($maintenance_array, $row);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    echo json_encode($machine_type_array);
 

}
else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['message'=>'No post found']);
}
?>