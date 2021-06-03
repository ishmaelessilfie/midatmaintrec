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
            'default' => 'all_sait',
            'min_range' => 1
        ]
    ]);
}
else{
    $sait_id = 'all_sait';
}
$id = $_SESSION["id"];
$type = $_SESSION['type'];
 // $name = $_SESSION['name'];
// MAKE SQL QUERY
// IF GET POSTS ID, THEN SHOW POSTS BY ID OTHERWISE SHOW ALL POSTS
if($type =='Technician'){
$sql = is_numeric($sait_id) ? "SELECT s.id,s.part_replaced,s.ispart_replaced,s.tech_date, s.sait_serial_number, s.date_tech, m.serial_number,s.problem_statement,s.date_recieved,s.acknowlegement_status , s.technician,o.branch_name as original_branch, b.branch_name as branch_from from sait_repository s join machines m on m.id = s.sait_serial_number join branch b on b.id = s.branch_from_id join branch o on s.original_branch_id = o.id where sait_repository.id ='sait_id' order by s.id desc" : "SELECT s.id,s.part_replaced, s.ispart_replaced, s.tech_date, s.sait_serial_number, s.date_recieved,m.serial_number,s.technician,s.problem_statement,s.date_recieved,s.acknowlegement_status ,o.branch_name as original_branch, b.branch_name as branch_from from sait_repository s join machines m on m.id = s.sait_serial_number join  branch b on b.id = s.branch_from_id join branch o on s.original_branch_id = o.id where technician = (SELECT admin.name from admin where id = $id) order by s.id desc"; 
}else{
$sql = is_numeric($sait_id) ? "SELECT s.id, s.tech_date,s.part_replaced, s.status, s.sait_serial_number, s.date_tech, m.serial_number,s.problem_statement,s.date_recieved,s.acknowlegement_status ,s.technician,o.branch_name as original_branch, b.branch_name as branch_from from sait_repository s join machines m on m.id = s.sait_serial_number join branch b on b.id = s.branch_from_id join branch o on s.original_branch_id = o.id where sait_repository.id ='sait_id' order by s.id desc" : "SELECT s.id, s.tech_date, s.technician, s.part_replaced, s.ispart_replaced, s.sait_serial_number, s.date_recieved,m.serial_number,s.problem_statement,s.date_recieved,s.acknowlegement_status ,o.branch_name as original_branch, b.branch_name as branch_from from sait_repository s  join machines m on m.id = s.sait_serial_number join  branch b on b.id = s.branch_from_id join branch o on s.original_branch_id = o.id order by s.id desc";
}

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