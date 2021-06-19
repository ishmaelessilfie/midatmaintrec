<?php

include('https://midatlanticmaintsys.herokuapp.com/maintsys.php');

$user = new maintsys();

if($_POST["email"])
{
	// sleep(2);
	$error = '';
	$type = '';
	$data = array(
		':email'=>$_POST["email"]
	);
	$user->query = "SELECT * FROM admin WHERE email = :email";
	$user->execute($data);

	$total_row = $user->row_count();

	if($total_row == 0)
	{
		$error = 'Wrong Email Address';
	}
	else
	{
		$result = $user->statement_result();
		foreach($result as $row)
		{
			if($row["status"] == 'Enable')
			{
				if(password_verify($_POST["password"], $row["password"]))
				{
					$_SESSION['id'] = $row['id'];
					$_SESSION['type'] = $row['type'];
					$type = $_SESSION['type'];
				}
				else
				{
					$error = 'Wrong Password';
				}
			}
			else
			{
				$error = 'Sorry, Your account has been disabled, Please contact Administrator';
			}
		}
	}
	$output = array(
		'error'		=>	$error,
		'type' => $type
	);
	echo json_encode($output);
}

?>
