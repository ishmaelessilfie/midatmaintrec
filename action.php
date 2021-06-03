<?php

include('maintsys.php');

$user = new maintsys();

if($_POST["action"] == 'fetch_single')
  {
    $user->query = "
    SELECT * from machines left join brand on brand.id = machines.brand_id
     left join machine_type on machine_type.id = machines.machine_type_id
     left join branch on branch.id=machines.branch_id 
    WHERE machines.id = '".$_POST["id"]."'";

    $result = $user->get_result();

    $data = array();

    foreach($result as $row)
    {
      $data['id'] = $row['id'];
      $data['serial_number'] = $row['serial_number'];
      $data['branch_id'] = $row['branch_id'];
      $data['brand_id'] = $row['brand_id'];
      $data['machine_type_id'] = $row['machine_type_id'];
      $data['created_on'] = $row['created_on'];
      $data['brand_name'] = $row['brand_name'];
      $data['machine_type'] = $row['machine_type'];
      $data['branch_name'] = $row['branch_name'];
      $data['contact_info'] = $row['contact_info'];
    }

    echo json_encode($data);
  }
  
if($_POST["action"] == 'fetch_single_maintenance')
  {
    $user->query = "
    SELECT *, maintenance.id  as maintid from maintenance left join  machines on machines.id = maintenance.machine_id 
    left join brand on brand.id= maintenance.brand_id left join branch on branch.id = maintenance.branch_id
    left join admin on admin.id = maintenance.technician_id
    left join machine_type on machine_type.id = machines.machine_type_id 
      where maintenance.id = '".$_POST["id"]."'";
    $result = $user->get_result();
    $data = array();
    foreach($result as $row)
    {
      $data['id'] = $row['id'];
      $data['date_added'] = $row['date_added'];
      $data['statuss'] = $row['statuss'];
      $data['technician_id'] = $row['technician_id'];
      $data['part_replaced'] = $row['part_replaced'];
      $data['problem_statement'] = $row['problem_statement'];
      $data['ispart_replaced'] = $row['ispart_replaced'];
      $data['machine_id'] = $row['machine_id'];
      $data['venue'] = $row['venue'];
      $data['branch_id'] = $row['branch_id'];
      $data['cur_branch'] = $row['cur_branch'];
      $data['recommendation'] = $row['recommendation'];
      $data['serial_number'] = $row['serial_number'];
      $data['machine_type_id'] = $row['machine_type_id'];
      $data['created_on'] = $row['created_on'];
      $data['zone'] = $row['zone'];
      $data['brand_name'] = $row['brand_name'];
      $data['branch_name'] = $row['branch_name'];
      $data['name'] = $row['name'];
      $data['machine_type'] = $row['machine_type'];
      $data['brand_id'] = $row['brand_id'];
      $data['maintid'] = $row['maintid'];
    }
    echo json_encode($data);
  }

  if($_POST["action"] == 'add_maintenance')
  {
    $error = '';
    $success = '';
    $data = array(
      ':machine'  =>  $_POST["machine"]
    );
    $user->query = "
    SELECT * FROM maintenance 
    WHERE machine_id = :machine AND DATE(date_added) = DATE(NOW())
    ";

    $user->execute($data);

    if($user->row_count() > 0)
    {
      $error = 'Maintenance for this machine for today is already taken';
    }else{
      if(!$user->is_master_user()){
      $data = array(
        ':machine'          =>  $user->clean_input($_POST["machine"]),
        ':brand_id'            =>  $_POST["hidden_brand"],
        ':branch_id'           =>  $_POST["hidden_original_branch"],
        ':technician'       =>  $_SESSION["id"],
        ':statuss'           =>  $_POST["statuss"],
        ':problem_statement'=>  $_POST["problem_statement"],
        ':ispart_replaced'  =>  $_POST["ispart_replaced"],
        ':part_replaced'    =>  $_POST["part_replaced"],
        ':venue'            =>  $_POST["venue"],
        ':recommendation'   =>  $_POST["recommendation"],
        ':cur_branch'       =>  $_POST["cur_branch"],
        ':date_added'       =>  $user->get_datetime(),
      );
    }else{
      $data = array(
        ':machine'          =>  $user->clean_input($_POST["machine"]),
        ':brand_id'            =>  $_POST["hidden_brand"],
        ':branch_id'           =>  $_POST["hidden_original_branch"],
        ':technician'       =>  $_POST["technician"],
        ':statuss'           =>  $_POST["statuss"],
        ':problem_statement'=>  $_POST["problem_statement"],
        ':ispart_replaced'  =>  $_POST["ispart_replaced"],
        ':part_replaced'    =>  $_POST["part_replaced"],
        ':venue'            =>  $_POST["venue"],
        ':recommendation'   =>  $_POST["recommendation"],
        ':cur_branch'       =>  $_POST["cur_branch"],
        ':date_added'       =>  $user->get_datetime(),
      );
    }
      if(!$user->is_master_user()){
      $user->query = "
      INSERT INTO maintenance(machine_id,technician_id,branch_id,brand_id,date_added,problem_statement,statuss,venue,part_replaced,ispart_replaced,cur_branch,recommendation)

                      VALUES (:machine,:technician,:branch_id,:brand_id,:date_added,:problem_statement,:statuss,:venue,:part_replaced,:ispart_replaced,:cur_branch,:recommendation)";
}else{
        $user->query = "
      INSERT INTO maintenance(machine_id,branch_id,technician_id,brand_id,date_added,problem_statement,statuss,venue,part_replaced,ispart_replaced,cur_branch,recommendation)

                      VALUES (:machine,:branch_id,:technician,:brand_id,:date_added,:problem_statement,:statuss,:venue,:part_replaced,:ispart_replaced,:cur_branch,:recommendation)";
}

      $user->execute($data);

      $success = 'Record Added Successfully';
    }

    $output = array(
      'error'   =>  $error,
      'success' =>  $success
    );

    echo json_encode($output);

  }

if($_POST["action"] == 'fetch_maintenance')
  {
    $order_column = array('date_added', 'machine_type', 'serial_number', 'branch_name',
       'venue', 'statuss','name');
    $output = array();
    $main_query = "SELECT maintenance.id,date_added,venue,statuss,serial_number,branch_name,admin.name,machine_type from maintenance 
      left join machines on machines.id = maintenance.machine_id
      left join branch on branch.id=maintenance.branch_id 
      -- left join technician on technician.id = maintenance.technician_id 
      left join admin on admin.id = maintenance.technician_id
      left join machine_type on machine_type.id = machines.machine_type_id where branch_name != '' ";

    // $search_query = '';
      if(!$user->is_master_user())
    {
      $main_query .= "
      AND technician_id = '".$_SESSION["id"]."' 
      ";
    }
     $search_query = '';
    if(isset($_POST["search"]["value"]))
    {
      $search_query .= 'AND (date_added LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR machine_type LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR serial_number LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR branch_name LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR venue LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR statuss LIKE "%'.$_POST["search"]["value"].'%" ';

      if($user->is_master_user())
      {
        $search_query .= 'OR name LIKE "%'.$_POST["search"]["value"].'%" )';
        
      }
      else
      {
        $search_query .= ') ';
      }
      
    }

    if(isset($_POST["order"]))
    {
      $order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
      $order_query = 'ORDER BY id DESC ';
    }

    $limit_query = '';

    if($_POST["length"] != -1)
    {
      $limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $user->query = $main_query . $search_query . $order_query;

    $user->execute();

    $filtered_rows = $user->row_count();

    $user->query .= $limit_query;

    $result = $user->get_result();

    $user->query = $main_query;

    $user->execute();

    $total_rows = $user->row_count();

    $data = array();

    foreach($result as $row)
    {
      $sub_array = array();
      $sub_array[] = $row["date_added"];
      $sub_array[] = ($row["machine_type"]);
      $sub_array[] = ($row["serial_number"]);
      $sub_array[] = ($row["branch_name"]);
      $sub_array[] = ($row["venue"]);
      // $sub_array[] = ($row["statuss"]);
      $statuss = '';

      if($row["statuss"] == 'Good')
      {
        $statuss = '<span class="label label-success pull-left">Good</span>';
      }
      else
      {
        $statuss = '<span class="label label-danger pull-left">Faulty</span>';
      }

      $sub_array[] = $statuss;

       // $sub_array[] = ($row["name"]);
  if($user->is_master_user())
      {
        $sub_array[] = ($row["name"]);
      }
   

      $sub_array[] = '
      <div align="center">
      <button type="button" name="view_button" class="btn btn-primary btn-sm view_button" data-id="'.$row["id"].'"><i class="fa fa-eye"></i></button>
      &nbsp;
      <button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="'.$row["id"].'"><i class="fa fa-edit"></i></button>
      &nbsp;
      <button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["id"].'"><i class="fa fa-times"></i></button>
      </div>
      ';
      $data[] = $sub_array;
    }
    $output = array(
      "draw"          =>  intval($_POST["draw"]),
      "recordsTotal"    =>  $total_rows,
      "recordsFiltered"   =>  $filtered_rows,
      "data"          =>  $data
    ); 
    echo json_encode($output);
  }

if($_POST["action"] == 'select_from_sait_to_maintenance')
  {

    $success = '';

      $user->query = "
      INSERT INTO maintenance(machine_id,branch_id,technician_id,brand_id,date_added,problem_statement,statuss,venue,part_replaced,ispart_replaced,cur_branch,recommendation)
      SELECT sait_serial_number,original_branch_id,(select admin.id from admin left join sait_repository on sait_repository.technician = admin.name where sait_repository.id = '".$_POST["id"]."'),brand_id, NOW(),problem_statement,statuss,'Shop',part_replaced,ispart_replaced,branch_from_id,recommendation from sait_repository where sait_repository.id = '".$_POST["id"]."'";
      
      $user->execute();
      $success = 'Record Added Successfully';
    
    $output = array(
      
      'success' =>  $success
    );

    echo json_encode($output);

  }
?>