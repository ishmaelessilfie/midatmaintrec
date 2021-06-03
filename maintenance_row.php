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

 if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, maintenance.id  as maintid from maintenance left join  machines on machines.id = maintenance.machine_id 
		left join brand on brand.id= maintenance.brand_id left join branch on branch.id = maintenance.branch_id
		left join machine_type on machine_type.id = machines.machine_type_id left join technician on technician.id=maintenance.technician_id
		  where maintenance.id='$id'";       
$stmt = $conn->prepare($sql);

$stmt->execute();

//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $maintenance_Array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($maintenance_Array,$row);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    echo json_encode($maintenance_Array);
}

else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['NoData'=>'No records found']);
}
}
?>



