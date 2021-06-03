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
    //IF HAS ID PARAMETER
    $brand_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
        'options' => [
            'default' => 'all_brand',
            'min_range' => 1
        ]
    ]);
}
else{
    $brand_id = 'all_brand';
}

$sql = is_numeric($brand_id) ? "SELECT * FROM brand WHERE brand.id='$brand_id'" : "SELECT *  from brand"; 

$stmt = $conn->prepare($sql);

$stmt->execute();
//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $brand_array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($brand_array,$row);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    echo json_encode($brand_array);
 
}
else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['message'=>'No post found']);
}
?>