<?php
// SET HEADER
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once 'config/database.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();
// CHECK GET ID PARAMETER OR NOT
if(isset($_GET['id']))
{
    $branch_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
        'options' => [
            'default' => 'all_branch',
            'min_range' => 1
        ]
    ]);
}
else{
    $branch_id = 'all_branch';
}
$sql = is_numeric($branch_id) ? "SELECT * FROM branch WHERE branch.id='$branch_id'" : "SELECT * from branch"; 
$stmt = $conn->prepare($sql);
$stmt->execute();
//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $branch_array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($branch_array,$row);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    echo json_encode($branch_array);
}
else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['message'=>'No post found']);
}
?>