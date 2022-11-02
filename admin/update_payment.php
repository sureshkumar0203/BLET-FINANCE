<?php
ob_start();
session_start();
$sid = session_id();

//include_once '../includes/class.Main.php';

//Object initialization
//$dbf = new User();
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
if($_REQUEST[action]=="update")
{
	$string="payment_status='$_REQUEST[payment_status]',paid_date='$_REQUEST[paid_date]',remark='$_REQUEST[remark]'";
	$db->updateTable("installment_details",$string,"id='$_REQUEST[installment_id]'");
	header("location:add_all_other_info.php?id=$_REQUEST[vid]&#ANCH$_REQUEST[installment_id]");
	exit;
}


?>