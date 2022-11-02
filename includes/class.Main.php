<?php
//include_once 'config.php';
include_once 'class.dbFunctions.php';

//Involves Any User operations******************************************************************
class User extends Dbfunctions{
	
	//Database connect 
	public function __construct(){
		
		parent::__construct();
		$db = new Dbfunctions();
	}
	
	

	
	
	
	
	

	

	
	
	

	//Registration process 
	function register_user($company_id, $email, $password){
		$password = md5($password);
		$sql = mysql_query("SELECT id from users WHERE email = '$email'");
		$no_rows = mysql_num_rows($sql);
		if ($no_rows == 0){
			$result = mysql_query("INSERT INTO users values ('', '$company_id','$email','$password')") or die(mysql_error());
			return $result;
		}else{
			return FALSE;
		}
	}

	
	// Getting name
	function get_fullname($uid){
		$result = mysql_query("SELECT name FROM users WHERE uid = $uid");
		$user_data = mysql_fetch_array($result);
		echo $user_data['name'];
	}
	
	

	

	
	
	//FETCH ALL ROWS FROM A TABLE
	
	// ********************************END*************************************************************
	
	
	// ********************************END**************************************
}
# End Class
?>