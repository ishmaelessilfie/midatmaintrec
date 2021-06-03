
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

 $serial_number = json_encode($_POST['serial_number']);    
                       if($serial_number != "" ){  
                    $sql = "SELECT serial_number,branch_name,brand_name,recommendation, machine_type,date_added,venue,status,name,countt,problem_statement,part_replaced from  maintenance 
                     left join machine_type on machine_type.id = (select machine_type_id from machines where machines.id = $serial_number)
                     left join machines on machines.id = maintenance.machine_id 
                     left join brand on brand.id = machines.brand_id
                     left join branch on branch.id= maintenance.branch_id
                     left join admin on admin.id = maintenance.technician_id
                     cross join (select count(*)  countt from maintenance where machine_id = $serial_number) d
                     where  maintenance.machine_id = $serial_number ";       
$stmt = $conn->prepare($sql);

$stmt->execute();

//CHECK WHETHER THERE IS ANY POST IN OUR DATABASE
if($stmt->rowCount() > 0){
    // CREATE POSTS ARRAY
    $maintenance_statistics_Array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($maintenance_statistics_Array,$row);
        // PUSH POST DATA IN OUR $posts_array ARRAY
        // array_push($maintenance_array, $row);
    }
    //SHOW POST/POSTS IN JSON FORMAT
    echo json_encode($maintenance_statistics_Array);
 

}

else{
    //IF THER IS NO POST IN OUR DATABASE
    echo json_encode(['NoData'=>'No records found']);
}
}
?>



