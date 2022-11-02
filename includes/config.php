<?php
/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'macclesf_hydro');
define('DB_PASSWORD', 'hydro@2012');
define('DB_DATABASE', 'macclesf_hydro');
*/

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ble_finance_latest');

class DB_Class{
	function __construct(){
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or
		die('Oops connection error -> ' . mysqli_connect_error());
		mysqli_select_db($connection,DB_DATABASE)
		or die('Database error -> ' . mysqli_error());
	}
}
/**********************General WebSite Settings************************************/
//define('DATE_FORMAT', 'd-M-Y');
//define('DATE_TIME_FORMAT', 'd-M-Y, h:i a');
date_default_timezone_set("UTC");
?>