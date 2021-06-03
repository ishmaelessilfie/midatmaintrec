<?php
include('maintsys.php');
$user = new maintsys();

if($_POST["action"] == 'fetch_sait')
  {
    $order_column = array('serial_number', 'problem_statement', 'branch_from', 'original_branch','date_recieved', 'name');

    $output = array();

    $main_query = "SELECT s.id,s.serial_number,admin.name,s.problem_statement,s.date_recieved,s.acknowlegement_status ,o.branch_name as original_branch, b.branch_name as branch_from from sait_repository s join admin on admin.id=s.technician_id join  branch b on b.id = s.branch_from_id join branch o on s.original_branch_id = o.id where s.id != '' ";
     $search_query = '';
    if(isset($_POST["search"]["value"]))
    {
      $search_query .= 'AND (serial_number LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR problem_statement LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR branch_from LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR original_branch LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR date_recieved LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR admin.name LIKE "%'.$_POST["search"]["value"].'%" )';
    }

    if(isset($_POST["order"]))
    {
      $order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
      $order_query = 'ORDER BY admin.name DESC ';
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
      $sub_array[] = $row["serial_number"];
      $sub_array[] = ($row["problem_statement"]);
      $sub_array[] = ($row["branch_from"]);
      $sub_array[] = ($row["original_branch"]);
      $sub_array[] = ($row["date_recieved"]);
      $sub_array[] = ($row["name"]);
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
  ?>