<?php

class maintsys
{
// 	public $base_url = 'http://localhost/midatmaintrec/';
	public $base_url = 'https://midatmaintrec.herokuapp.com/';
	public $connect;
	public $query;
	public $statement;

	function maintsys()
	{
// 		$this->connect = new PDO("mysql:host=localhost;dbname=maintenance_db", "root", "");
		$this->connect = new PDO("mysql:host=remotemysql.com;dbname=FaWMAUm8P4", "FaWMAUm8P4", "qoWSTBdwMP");

		session_start();
	}
	
	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if($data)
		{
			$this->statement->execute($data);
		}
		else
		{
			$this->statement->execute();
		}		
	}
	function row_count()
	{
		return $this->statement->rowCount();
	}
	function statement_result()
	{
		return $this->statement->fetchAll();
	}
	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}
	function is_login()
	{
		if(isset($_SESSION['id']))
		{
			return true;
		}
		return false;
	}

	function is_master_user()
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION["type"] == 'Admin')
			{
				return true;
			}
			return false;
		}
		return false;
	}

	function is_sait()
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION["type"] == 'Sait')
			{
				return true;
			}
			return false;
		}
		return false;
	}
    
    function is_tech()
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION["type"] == 'Technician')
			{
				return true;
			}
			return false;
		}
		return false;
	}
	function clean_input($string)
	{
	  	$string = trim($string);
	  	$string = stripslashes($string);
	  	$string = htmlspecialchars($string);
	  	return $string;
	}
	function get_datetime()
	{
		return date("Y-m-d h:i:s",  STRTOTIME(date('h:i:sa')));
	}
	function Get_profile_image()
	{
		$this->query = "
		SELECT photo FROM admin
		WHERE id = '".$_SESSION["id"]."'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row['photo'];
		}
	}	
	function Get_profile_name()
	{
		$this->query = "
		SELECT name FROM admin
		WHERE id = '".$_SESSION["id"]."'
		";

		$result = $this->get_result();

		foreach($result as $row)
		{
			return $row['name'];
		}
	}
	function Get_total_machines()
	{
		$this->query = "
		SELECT * FROM machines ";
		
		$this->execute();
		return $this->row_count();
	}
	function Get_total_maintenance_for_the_quarter()
	{
		$this->query = "
		SELECT * from maintenance ";
		
		$this->execute();
		return $this->row_count();
	}
	function Get_total_maintenance_for_a_day()
	{
		$this->query = "
		SELECT * FROM maintenance WHERE DATE(date_added) = Date(NOW()) ";
		
		$this->execute();
		return $this->row_count();
	}
	function Get_total_branches_for_a_day()
	{
		$this->query = "
		SELECT DISTINCT cur_branch FROM maintenance where DATE(date_added) = DATE(NOW()) ";
		
		$this->execute();
		return $this->row_count();
	}	
    function Get_total_sait()
	{
		$this->query = "
		SELECT *  from sait_repository where acknowlegement_status ='not' ";
		
		$this->execute();
		return $this->row_count();
	}
    function Get_total_task()
	{
	
		$this->query = "
		SELECT *  from sait_repository where acknowlegement_status ='assigned' AND technician = (SELECT name FROM admin
		WHERE id = ".$_SESSION["id"].")";
		
		$this->execute();
		return $this->row_count();
	}
	function load_branch()
	{
		$this->query = "
		SELECT * FROM branch
		";
		$result = $this->get_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value='.$row["id"].'>'.$row["branch_name"].'</option>';
		}
		return $output;
	}
	function load_brand()
	{
		$this->query = "SELECT * FROM brand";
		$result = $this->get_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value='.$row["id"].'>'.$row["brand_name"].'</option>';
		}
		return $output;
	}
	function load_machine_type()
	{
		$this->query = "
		SELECT * FROM machine_type 
		
		";
		$result = $this->get_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value='.$row["id"].'>'.$row["machine_type"].'</option>';
		}
		return $output;
	}

	function load_machine_serial_number()
	{
		$this->query = "
		SELECT id, serial_number FROM machines
		
		";
		$result = $this->get_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value='.$row["id"].'>'.$row["serial_number"].'</option>';
		}
		return $output;
	}

	function load_technician()
	{
		$this->query = "
		SELECT id, name FROM admin where type != 'Sait' AND type !='Admin'
		
		";
		$result = $this->get_result();
		$output = '';
		foreach($result as $row)
		{
			$output .= '<option value='.$row["id"].'>'.$row["name"].'</option>';
		}
		return $output;
	}
}

?>
