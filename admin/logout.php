<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//$dbf = new User();

/*$delstring="userid='0' AND transaction_id='' AND payment_status='Unpaid'";
foreach($db->fetch("master_order",$delstring,"","","") as $del_id)
{
	$db->deleteFromTable("master_order","order_id=$del_id[order_id]");
	$db->deleteFromTable("order_items","order_id=$del_id[order_id]");
}*/
	
$db->user_logout();
header("location:index.php");

?>