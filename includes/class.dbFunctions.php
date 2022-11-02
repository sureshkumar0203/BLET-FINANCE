<?php
include_once 'class.Pagination.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE);
class Dbfunctions extends Pagination
{
//Database connect 
public $mysqli;
public function __construct()
{
	$localhost = "localhost";
	$username = "root";
	$password = "";
	$db = "ble_finance_latest";
	$this->mysqli = new mysqli($localhost,$username,$password,$db) or
		die('Oops connection error -> ' . mysqli_connect_error()); 
}




/****Newly added Fuctions******/

//FETCH SINGLE ROW FROM A TABLE
	function fetchSingle($tblName,$optCondition=""){
		
		if(trim($optCondition) != ""){
			$condition = " WHERE " . $optCondition;
		}else{
			$condition = "";
		}
		
        $sql="SELECT * FROM " . $tblName . $condition;
		$result = $this->mysqli->query($sql); 
		return $result->fetch_array(MYSQLI_BOTH);
	}

	// Login process
	function check_login($emailusername, $password){
		//$password = md5($password);
		$result = $this->mysqli->query("SELECT * from admin WHERE email  = '$emailusername'  and password = '$password' AND active_status='1'");
		$admin_data = $result->fetch_array(MYSQLI_BOTH);
		$no_rows = $result->num_rows;
		if ($no_rows == 1)
		{
			$_SESSION['login'] = true;
				
			$_SESSION['admin_id'] = $admin_data['id'];
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// Getting session 
	function get_session(){
		if(isset($_SESSION['login'])){
			return $_SESSION['login'];
		}
		
	}

	/*Returns data value if data exists in a table (suitable for integer or string data) */
	function getDataFromTable($tblName, $fldName,  $optCondition){
		$defaultVal="";
		if(trim($optCondition) != ""){
			$condition = $optCondition ;
		}else{
			$condition = "";
		}
		//echo ("select " . $fldName . " from " . $tblName . " where " . $condition);
		$rs = $this->mysqli->query("select " . $fldName . " from " . $tblName . " where " . $condition);	
		if( (!($rs)) || (!($rec=$rs->fetch_array(MYSQLI_BOTH)))){
			//not found
			return $defaultVal;
		}else if(is_null($rec[0])){
			//found
			return $defaultVal;
		}else{
			//found
			return $rec[0];
		}
	}

	//FETCH SINGLE ROW or specific Column FROM A TABLE (Kishor - 17-09-2011)
	function strRecordID($tblName,$field,$optCondition=""){
		if(trim($optCondition) != ""){
			$sql = "SELECT ".$field." from ".$tblName." WHERE " . $optCondition;
		}else{
			$sql = "SELECT ".$field." from ".$tblName;
		}
		//echo $sql;
		$result = $this->mysqli->query($sql);
		return $result->fetch_array(MYSQLI_BOTH);
	}


//TOTAL ROWS
	function countRows($tblName,$optCondition=""){
		
		if(trim($optCondition) != ""){
			$condition = " WHERE " . $optCondition;
		}else{
			$condition = "";
		}
		
		$sql="SELECT * FROM " . $tblName . $condition;
		$result = $this->mysqli->query($sql);
		if($result){
			$num=$result->num_rows;
			return $num;
		}
	}

	//DELETE DATA FROM TABLE
	function deleteFromTable($tblName, $condition){
		
		if(trim($condition) != ""){
			$condition = " WHERE " . $condition;
		}else{
			$condition = "";
		}
		$rs= $this->mysqli->query("DELETE FROM " . $tblName . $condition);
	}


//Number of months between 2 date
	function GetNoofMonths_In2dates($firstdate, $secdate){
		$date1 = date(strtotime($firstdate));
		$date2 = date(strtotime($secdate));
		
		$difference = $date2 - $date1;
		$months = floor($difference / 86400 / 30 );
		return $months;
	}

	//INSERT TO TABLE USING SET METHOD******
	function insertSet($tblName,$string){
		$condition = "INSERT INTO  " . $tblName . " SET " .  $string;
		$rs= $this->mysqli->query($condition);
		if($rs){
			$lastId=$this->mysqli->insert_id;
			return $lastId;
		}else{
			return 0;
		}
	}

	//UPDATE  TABLE
	function updateTable($tblName,$string, $condition){
		
		$condition = " WHERE " . $condition;
		$rs= $this->mysqli->query("UPDATE " . $tblName . " SET " .  $string . $condition);
	}
	// Logout 
	function user_logout(){
		$_SESSION['login'] = FALSE;
		session_destroy();
	}

	//FETCH ALL ROWS FROM A TABLE WITH ORDER BY (Kishor - 16-09-2011)
	function fetchOrder($tblName,$optCondition="",$orderby=""){

		$sql = "SELECT * FROM ".$tblName;
		if(trim($optCondition) != ""){
			$sql = $sql." WHERE " . $optCondition;
		}
		if(trim($orderby) != ""){
			$sql = $sql." order by " . $orderby;
		}
		//echo $sql;
		$result = $this->mysqli->query($sql);
		if(!$result){
			trigger_error("Problem selecting data");
		}
		while($row =$result->fetch_array(MYSQLI_BOTH)){
			$result_array[] = $row;
		}
		if(isset($result_array) && count($result_array)>0){
			return $result_array;	
		}else{
			$default_val=array();
			return $default_val;
		}
	}

	//foreach($dbf->fetch('products','','post_date','limit 4','DESC') as $res) {
	function fetch($tblName,$optCondition="",$optorder="",$optlimit="",$optorderType="ASC"){
	
		if(trim($optCondition) != ""){
			$condition = " WHERE " . $optCondition;
		}else{
			$condition = "";
		}		
		if(trim($optlimit) != ""){
			$limit = " ".$optlimit;
		}else{
			$limit = "";
		}
		if(trim($optorder) != ""){
			$sql = "SELECT * FROM " . $tblName . $condition ." ORDER BY ". $optorder." ".$optorderType. $limit;
		}else{
			$sql = "SELECT * FROM " . $tblName . $condition. $limit;
		}
		//echo $sql;
		$result = $this->mysqli->query($sql);
		if(!$result){
			trigger_error("Problem selecting data");
		}
		while($row =$result->fetch_array(MYSQLI_BOTH)){
			$result_array[] = $row;
		}
		if(count($result_array)>0){
			return $result_array;
		}else{
			$default_val=array();
			return $default_val;
		}
	}	
/****End Section *****/	








	/*Returns only 1 data *************************/
	public function getFirstData($tblName, $fldName,  $optCondition)
	{
	$defaultVal="";
	
		if(trim($optCondition) != "")
		{
			$condition = " WHERE " . $condition;
		}
		else
		{
			$condition = "";
		}
	//echo ("select " . $fldName . " from " . $tblName . " where " . $condition);

		$rs = $this->mysqli->query("select " . $fldName . " from " . $tblName . $condition. " LIMIT 0,1");
	
		if( (!($rs)) || (!($rec=$rs->fetch_array(MYSQLI_BOTH))) )
		{
			//not found
			return $defaultVal;
		}
		else if(is_null($rec[0]))
		{
			//found
			return $defaultVal;
		}
		else
		{
			//found
			return $rec[0];
		}
	}

// ********************************************END**********************************************************************	
	
	
	
	//CHECKING EXISTANCE  IN A TABLE
	public function existsInTable($tblName, $condition)
	{
	
	if(trim($condition) != "")
		{
			$condition = " WHERE " . $condition;
		}
		else
		{
			$condition = "";
		}
		//echo ("select * from " . $tblName . " where " . $condition)."<br>";
		
		$rs = $this->mysqli->query("select * from " . $tblName . $condition);
		if( (!($rs)) || (!($rec=$rs->fetch_array(MYSQLI_BOTH))) )
		{
			//not found
			return 0;
		}
		else
		{
			//found
			return 1;
		}
	}


//INSERT DATA INTO TABLE AND GET THE INSERTED ID**********************************************
	public function insertToTable($tblName, $string)
	{
		$rs= $this->mysqli->query("INSERT INTO " . $tblName . " VALUES(". $string.")");
		if($rs)
		{
		$lastId=$this->mysqli->insert_id;
		return $lastId;
		}
		else
		{
		return 0;
		}
	}
//FETCH  ROWS FROM A TABLE USING DISTINCT
function fetchDistinct($tblName,$distinctname,$optCondition="",$optorder="",$optlimit="",$optorderType="ASC") 
{
	if(trim($optCondition) != "")
	{
	$condition = " WHERE " . $optCondition;
	}
	else
	{
	$condition = "";
	}
	
	if(trim($optlimit) != "")
	{
	$limit = " ".$optlimit;
	}
	else
	{
		$limit = "";
	}
	
if(trim($optorder) != "")	
{
 $sql="SELECT distinct(".$distinctname.") FROM " . $tblName . $condition ." ORDER BY ". $optorder." ".$optorderType. $limit;
 }
 else
 {
 $sql="SELECT distinct(".$distinctname.") FROM " . $tblName . $condition. $limit;
 }
 //echo $sql;
 $result = $this->mysqli->query($sql);
 if(!$result){
  trigger_error("Problem selecting data");
 }
 while($row = $result->fetch_array(MYSQLI_BOTH)){
  $result_array[] = $row;
 }
if(count($result_array)>0)
{
 return $result_array;	
 }
 else
 {
 $default_val=array();
 return $default_val;
 }
}

// ********************************END****************************************************************************************	


//Next Auto increment value of a table.
public function autoIncrement($tblName,$string, $condition)
{
$query_next = $this->mysqli->query("SHOW TABLE STATUS LIKE '". $tblName."'");
$row_next = $query_next->fetch_array(MYSQLI_BOTH);
 $next_id = $row_next[Auto_increment] ;//exit;
 return $next_id;
}
// ********************************END****************************************************************************************	

//FETCH ALL ROWS FROM A TABLE USING LEFT JOIN
function leftJoin($tblName1,$tblName2,$tbl1Param,$tbl2Param,$optCondition="",$optDistinct="id") 
{
	if(trim($optCondition) != "")
	{
	$condition = " WHERE " . $optCondition;
	}
	else
	{
	$condition = "";
	}
	
	
   $sql="SELECT DISTINCT ". $tblName1.".".$optDistinct." FROM " . $tblName1 . " LEFT JOIN ". $tblName2 ." ON ".$tblName1.".".$tbl1Param."=".$tblName2.".".$tbl2Param. $condition;
 $result = $this->mysqli->query($sql);
 
 if(!$result){
  trigger_error("Problem selecting data");
 }
 while($row = $result->fetch_array(MYSQLI_BOTH)){
  $result_array[] = $row;
 }
if(count($result_array)>0)
{
 return $result_array;	
 }
 else
 {
 $default_val=array();
 return $default_val;
 }
}

// ********************************END****************************************************************************************	


//FETCH ALL ROWS FROM A TABLE USING LEFT JOIN
function leftJoinCount($tblName1,$tblName2,$tbl1Param,$tbl2Param,$optCondition="") 
{
	if(trim($optCondition) != "")
	{
	$condition = " WHERE " . $optCondition;
	}
	else
	{
	$condition = "";
	}
	
  $sql="SELECT DISTINCT ". $tblName1.".id FROM " . $tblName1 . " LEFT JOIN ". $tblName2 ." ON ".$tblName1.".".$tbl1Param."=".$tblName2.".".$tbl2Param. $condition;
 $result = $this->mysqli->query($sql);
 return $result->num_rows;

}

// ********************************END****************************************************************************************	

//FETCH SINGLE ROW or specific Column FROM A TABLE (Kishor - 17-09-2011)
function fetchColumns($tblName,$field,$optCondition="") 
{
	if(trim($optCondition) != "")
	{
		$sql = "SELECT ".$field." from ".$tblName." WHERE " . $optCondition;
	}
	else
	{
		$sql = "SELECT ".$field." from ".$tblName;
	}
	//echo $sql;

 $result = $this->mysqli->query($sql);
return $result->fetch_array(MYSQLI_BOTH);
}
// ********************************END****************************************************************************************	



//FETCH SINGLE ROW or specific Column FROM A TABLE (Kishor - 17-09-2011)
function fetchmultiColumns($tblName,$field,$optCondition="") 
{
	if(trim($optCondition) != "")
	{
		$sql = "SELECT ".$field." from ".$tblName." WHERE " . $optCondition;
	}
	else
	{
		$sql = "SELECT ".$field." from ".$tblName;
	}
	//echo $sql;


$result = $this->mysqli->query($sql);
 if(!$result){
  trigger_error("Problem selecting data");
 }
 while($row = $result->fetch_array(MYSQLI_BOTH)){
  $result_array[] = $row;
 }
if(count($result_array)>0)
{
 return $result_array;	
 }
 else
 {
 $default_val=array();
 return $default_val;
 }
}
// ********************************END****************************************************************************************	

/*Format Date Time to d-M-Y or any other...*/
	public function formatMyDateTime($a_date, $a_format, $is_time_stamp = 0, $a_default_value = "")
	{
		if(is_null($a_date))
		{
			return($a_default_value);
		}
		else
		{
			if($is_time_stamp == 1)
			{
				//--- supplied date time is a TimeStamp, so no conversion required
				$tmpdt_stamp = $a_date;
			}
			else
			{
				//--- supplied date time is not a TimeStamp, but a string
				$tmpdt_stamp = strtotime($a_date);
			}
			return(date($a_format, $tmpdt_stamp));
		}
	}
	
	
	
//String cut to a limited words************************************************	
public function cut($string, $max_length){
	if (strlen($string) > $max_length){
		$string = substr($string, 0, $max_length);
		$pos = strrpos($string, " ");
		if($pos === false) {
				return substr($string, 0, $max_length)."...";
		}
			return substr($string, 0, $pos)."...";
	}else{
		return $string;
	}
}	
//***********************************************	


 //calculate years of age (input string: YYYY-MM-DD)
  public function age($birthday){
    list($year,$month,$day) = explode("-",$birthday);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($day_diff < 0 || $month_diff < 0)
      $year_diff--;
    return $year_diff;
  }
  
  
//Text Area formatting************************************************	
public function textArea($string){
	$str = str_replace("\r",'<br>',$string); 
 $str=stripslashes($str);	//exit;
$str=$this->mysqli->real_escape_string($str);
return $str;
}	
//***********************************************	  




//FIND URL OF THE SITE *******************************************************

public function get_server() {
	$protocol = 'http';
	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
		$protocol = 'https';
	}
	$host = $_SERVER['HTTP_HOST'];
	$baseUrl = $protocol . '://' . $host;
	if (substr($baseUrl, -1)=='/') {
		$baseUrl = substr($baseUrl, 0, strlen($baseUrl)-1);
	}
	return $baseUrl;
}

//********************************************************************************



//FIND URL OF THE SITE *******************************************************

public function createStars($green) {
	$white=5-$green;
for($i=1;$i<=$green;$i++)
	{
	echo '<img src="images/green_star.gif" width="16" height="16" align="top">  ';
	}
for($i=1;$i<=$white;$i++)
	{
	echo '<img src="images/white_star.gif" width="16" height="16" align="top">  ';
	}

}





/*public function dateTimeDiff($data_ref)
{
	
	// Get the current date
	 
	  $current_date = date('Y-m-d H:i:s');
	   $timeDiff=strtotime($data_ref)-strtotime($current_date);
	
	// Extract from $current_date
	$current_year = substr($current_date,0,4);
	$current_month = substr($current_date,5,2);
	$current_day = substr($current_date,8,2);
	
	// Extract from $data_ref
	$ref_year = substr($data_ref,0,4);
	$ref_month = substr($data_ref,5,2);
	$ref_day = substr($data_ref,8,2);
	
	// create a string yyyymmdd 20071021
	 $tempMaxDate = $current_year . $current_month . $current_day;
	 $tempDataRef = $ref_year . $ref_month . $ref_day;
	
	   $tempDifference = $tempDataRef-$tempMaxDate;
	
	
	
	// Extract $current_date H:m:ss
	$current_hour = substr($current_date,11,2);
	$current_min = substr($current_date,14,2);
	$current_seconds = substr($current_date,17,2);
	
	// Extract $data_ref Date H:m:ss
	$ref_hour = substr($data_ref,11,2);
	$ref_min = substr($data_ref,14,2);
	$ref_seconds = substr($data_ref,17,2);
	
	 echo $dDf=$tempDifference;
	 $hDf = $ref_hour-$current_hour;
	  $mDf = $ref_min-$current_min;
	$sDf = $ref_seconds-$current_seconds;
	
	// Show time difference ex: 2 min 54 sec ago.
	if($timeDiff>0)
	{
	if($dDf<1)
	{
		if($hDf>0)
		{
			if($mDf<0)
			{
				$mDf = 60 + $mDf;
				$hDf = $hDf - 1;
				echo 'Closing in '.$hDf. ' hr '. $mDf . ' min ';
			} 
			else
			{
				echo 'Closing in '.$hDf. ' hr ';
			}
		}
		else
		{
			if($mDf>0)
			{
				echo 'Closing in '.$mDf . ' min ';
			}
			else
			{
				echo 'Closing in '.$sDf . ' sec ';
			}
		}
	}
	else
	{
		if($dDf>1)
		{
		$dayLabel=' days ';
		}
		else
		{
		$dayLabel=' day ';
		}
	
	
		if($hDf>0)
		{
			
				echo 'Closing in '.$dDf . $dayLabel. $hDf. ' hr ';
			
		}
		else
		{
			echo 'Closing in '.$dDf . $dayLabel;
		}
	}
	}
	else
	{
	echo 'CLOSED';
	}
	
  }
  */
  
  
  
  public function dateTimeDiff($data_ref)
  {
		   $time =  strtotime($data_ref)-time(); // to get the time since that moment
		
	if($time<0)
	{
	echo "CLOSED";
	}
else 
{
$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		/*604800 => 'week',*/
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
		);
	foreach ($tokens as $unit => $text) {
if ($time < $unit) continue;
$numberOfUnits = floor($time / $unit);


return "Closing in ".$numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');

		
		


}
	 	
}
}
  
}



//********************************************************************************

//FIND URL OF THE SITE *******************************************************

function get_server() {
	$protocol = 'http';
	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
		$protocol = 'https';
	}
	$host = $_SERVER['HTTP_HOST'];
	$baseUrl = $protocol . '://' . $host;
	if (substr($baseUrl, -1)=='/') {
		$baseUrl = substr($baseUrl, 0, strlen($baseUrl)-1);
	}
	return $baseUrl;
}

//********************************************************************************

//FETCH SINGLE ROW or specific Column FROM A TABLE (Kishor - 17-09-2011)
function strRecordID($tblName,$field,$optCondition="") 
{
	if(trim($optCondition) != "")
	{
		$sql = "SELECT ".$field." from ".$tblName." WHERE " . $optCondition;
	}
	else
	{
		$sql = "SELECT ".$field." from ".$tblName;
	}
	//echo $sql;
	$result = $this->mysqli->query($sql);
	return $result->fetch_array(MYSQLI_BOTH);
}
// ********************************END****************************************************************************************	

?>