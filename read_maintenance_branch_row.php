<?php
include('maintsys.php');

$user = new maintsys();

?>
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

$sql =  "SELECT * from machines left join brand on brand.id = machines.brand_id
     left join machine_type on machine_type.id = machines.machine_type_id
     left join branch on branch.id=machines.branch_id 
    WHERE machines.id='machine_id'"; 
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
    echo json_encode($branch_array);
}
else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['message'=>'No post found']);
}
?>