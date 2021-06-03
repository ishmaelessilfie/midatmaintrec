<?php

//user_action.php

include('maintsys.php');

$user = new maintsys();

if(isset($_POST["action"]))
{
  if($_POST["action"] == 'fetch')
  {
    $order_column = array('name', 'contact', 'email', 'created_on', 'type');

    $output = array();

    $main_query = "SELECT * FROM admin where type !='' ";

    $search_query = '';

    if(isset($_POST["search"]["value"]))
    {
      $search_query .= 'AND (name LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR contact LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR email LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR type LIKE "%'.$_POST["search"]["value"].'%" ';
      $search_query .= 'OR created_on LIKE "%'.$_POST["search"]["value"].'%") ';
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
      $sub_array[] = '<img src="'.$row["photo"].'" class="img-fluid img-thumbnail" width="75" height="75" />';
      $sub_array[] = html_entity_decode($row["name"]);
      $sub_array[] = $row["contact"];
      $sub_array[] = $row["email"];
      $sub_array[] = $row["type"];
      $sub_array[] = $row["created_on"];
      $delete_button = '';
      if($row["status"] == 'Enable')
      {
        $delete_button = '<button type="button" name="delete_button" class="btn btn-success btn-sm delete_button" data-id="'.$row["id"].'" data-status="'.$row["status"].'">'.$row["status"].'</button>';
      }
      else
      {
        $delete_button = '<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["id"].'" data-status="'.$row["status"].'">'.$row["status"].'</button>';
      }
      $sub_array[] = '
      <div align="center">
      <button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="'.$row["id"].'"><i class="fa fa-edit"></i> </button>
      &nbsp;
      <button type="button" name="delete_button" class="btn btn-danger btn-sm delete_user_button" data-id="'.$row["id"].'"><i class="fa fa-times"></i></button>
      &nbsp;
      '.$delete_button.'
      </div>';
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
//Add user

  function secure_random_string($length) {
    $random_string = '';
    for($i = 0; $i < $length; $i++) {
        $number = random_int(0, 36);
        $character = base_convert($number, 10, 36);
        $random_string .= $character;
    }
    return $random_string;
}

  if($_POST["action"] == 'Add')
  {
    $error = '';
    $success = '';
    $password = secure_random_string(7);
    $data = array(
      ':email'  =>  $_POST["email"]
    );

    $user->query = "
    SELECT * FROM admin 
    WHERE email = :email
    ";

    $user->execute($data);

    if($user->row_count() > 0)
    {
      $error = 'User Email Already Exists';
    }
    else
    {
      $photo = '';
      if($_FILES["photo"]["name"] != '')
      {
        $photo = upload_image();
      }
      else
      {
        $photo = make_avatar(strtoupper($_POST["name"][0]));
      }

      $data = array(
        ':name'   =>  $user->clean_input($_POST["name"]),
        ':contact' =>  $_POST["contact"],
        ':email'    =>  $_POST["email"],
        ':password' =>  password_hash($password, PASSWORD_DEFAULT),
        ':photo'  =>  $photo,
        ':type'   =>  $_POST["type"],
        ':created_on' =>  $user->get_datetime()
      );

      $user->query = "
      INSERT INTO admin 
      (name, contact, email, password, photo, type, created_on) 
      VALUES (:name, :contact, :email, :password, :photo, :type, :created_on)";
      $user->execute($data);
      $success = 'User Added Successfully';
    }

    $output = array(
      'error'   =>  $error,
      'success' =>  $success,
      'password' => $password
    );

    echo json_encode($output);

  }



  if($_POST["action"] == 'fetch_single')
  {
    $user->query = "
    SELECT * FROM admin 
    WHERE id = '".$_POST["id"]."'";

    $result = $user->get_result();

    $data = array();

    foreach($result as $row)
    {
      $data['name'] = $row['name'];
      $data['contact'] = $row['contact'];
      $data['email'] = $row['email'];
      $data['type'] = $row['type'];
      $data['photo'] = $row['photo'];
    }

    echo json_encode($data);
  }




  if($_POST["action"] == 'Edit')
  {
    $error = '';

    $success = '';

    $data = array(
      ':email'  =>  $_POST["email"],
      ':id'   =>  $_POST['hidden_id']
    );

    $user->query = "
    SELECT * FROM admin 
    WHERE email = :email 
    AND id != :id";

    $user->execute($data);

    if($user->row_count() > 0)
    {
      $error = 'User Email Already Exists';
    }
    else
    {
      $photo = $_POST["hidden_user_image"];
      if($_FILES["photo"]["name"] != '')
      {
        $photo = upload_image();
      }

      $data[':name'] = $user->clean_input($_POST["name"]);
      $data[':contact'] = $_POST["contact"];
      $data[':email'] = $_POST["email"];
      if($_POST["password"] != '')
      {
        $data[':password'] = password_hash($_POST["password"], PASSWORD_DEFAULT);
      }
      $data[':photo'] = $photo;

      if($_POST["password"] != '')
      {
        $data = array(
          ':name' =>  $user->clean_input($_POST["name"]),
          ':contact' =>  $_POST["contact"],
          ':email'  =>  $_POST["email"],
          ':type'  =>  $_POST["type"],
          ':password' =>  password_hash($_POST["password"], PASSWORD_DEFAULT),
          ':photo'  =>  $photo
        );

        $user->query = "
        UPDATE admin 
        SET name = :name, 
        contact = :contact, 
        email = :email,
        type=:type,
        password = :password, 
        photo = :photo 
        WHERE id = '".$_POST['hidden_id']."'
        ";

        $user->execute($data);
      }
      else
      {
        $data = array(
          ':name' =>  $user->clean_input($_POST["name"]),
          ':contact' =>  $_POST["contact"],
          ':email'  =>  $_POST["email"],
          ':type' => $_POST["type"],
          ':photo'  =>  $photo
        );

        $user->query = "
        UPDATE admin
        SET name = :name, 
        contact = :contact, 
        email = :email,
        type = :type,  
        photo = :photo 
        WHERE id = '".$_POST['hidden_id']."'
        ";

        $user->execute($data);
      }
      $success = 'User Details Updated Successfully';
    }
    $output = array(
      'error'   =>  $error,
      'success' =>  $success
    );
    echo json_encode($output);
  }





  if($_POST["action"] == 'delete')
  {
    $data = array(
      ':status'   =>  $_POST['next_status']
    );

    $user->query = "
    UPDATE admin 
    SET status = :status 
    WHERE id = '".$_POST["id"]."'
    ";

    $user->execute($data);

    echo 'User Status change to '.$_POST['next_status'].'';
  }

  if($_POST["action"] == 'photo')
  {
    sleep(2);

    $error = '';

    $success = '';

    $name = '';

    $contact = '';

    $email = '';
    $type = '';

    $photo = '';

    $data = array(
      ':email'  =>  $_POST["email"],
      ':id'   =>  $_POST['hidden_id']
    );

    $user->query = "SELECT * FROM admin WHERE email = :email AND id != :id";

    $user->execute($data);

    if($user->row_count() > 0)
    {
      $error = 'User Email Already Exists';
    }
    else
    {
      $photo = $_POST["hidden_user_image"];
      if($_FILES["photo"]["name"] != '')
      {
        $photo = upload_image();
      }

      $name = $user->clean_input($_POST["name"]);

      $contact = $_POST["contact"];

      $email = $_POST["email"];

      $photo = $photo;

      $data = array(
        ':name' =>  $name,
        ':contact' =>  $contact,
        ':email'  =>  $email,
        ':photo'  =>  $photo
      );

      $user->query = "
      UPDATE admin
      SET name = :name, 
      contact = :contact, 
      email = :email,  
      photo = :photo 
      WHERE id = '".$_POST['hidden_id']."'
      ";

      $user->execute($data);

      $success = 'User Details Updated Successfully';
    }

    $output = array(
      'error'   =>  $error,
      'success' =>  $success,
      'name'  =>  $name,
      'contact'  =>  $contact,
      'email' =>  $email,
      'photo' =>  $photo
    );

    echo json_encode($output);
  }

  if($_POST["action"] == 'change_password')
  {
    $error = '';
    $success = '';
    $user->query = "
    SELECT password FROM admin 
    WHERE id = '".$_SESSION["id"]."'
    ";

    $result = $user->get_result();

    foreach($result as $row)
    {
      if(password_verify($_POST["current_password"], $row["password"]))
      {
        $data = array(
          ':password' =>  password_hash($_POST["new_password"], PASSWORD_DEFAULT)
        );
        $user->query = "
        UPDATE admin
        SET password = :password 
        WHERE id = '".$_SESSION["id"]."'";

        $user->execute($data);

        $success = 'Password Changed Successfully';
      }
      else
      {
        $error = 'You have entered wrong current password';
      }
    }
    $output = array(
      'error'   =>  $error,
      'success' =>  $success
    );
    echo json_encode($output);
  }
}
if($_POST["action"] == 'delete_user')
  {
    $user->query = "
    DELETE FROM admin 
    WHERE id = '".$_POST["id"]."'
    ";

    $user->execute();

    echo 'User Details Deleted Successfully';
  }
function upload_image()
{
  if(isset($_FILES["photo"]))
  {
    $extension = explode('.', $_FILES['photo']['name']);
    $new_name = rand() . '.' . $extension[1];
    $destination = 'img/' . $new_name;
    move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
    return $destination;
  }
}

function make_avatar($character)
{
    $path = "img/". time() . ".png";
  $image = imagecreate(200, 200);
  $red = rand(0, 255);
  $green = rand(0, 255);
  $blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);  
    $textcolor = imagecolorallocate($image, 255,255,255);  

    // imagettftext($image, 100, 0, 55, 150, $textcolor, '/font/arial.ttf', $character);
    imagepng($image, $path);
    imagedestroy($image);
    return $path;
}

?>