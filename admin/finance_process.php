<?php
ob_start();
session_start();
include 'application_top.php';

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();

//Object initialization
//$dbf = new User();

$res=$db->fetchSingle("vehicle_registration","id='$_REQUEST[vid]'");
	
//Upadte to vehicle_registration table
$vehicle_no=strtoupper($_POST[vid]);
$finance_by=strtoupper($_POST[finance_by]);
$payment_bank=strtoupper($_POST[payment_bank]);
$farm_name=strtoupper($_POST[farm_name]);

if($res[no_of_installment]=="")
{
	$string="installment_per_month='$_POST[installment_per_month]',loan_start_date='$_POST[loan_start_date]',loan_end_date='$_POST[loan_end_date]',finance_amount='$_POST[finance_amount]',interest_amount='$_POST[interest_amount]',total_amount_paid_to_bank='$_POST[total_amount_paid_to_bank]',no_of_installment='$_POST[no_of_installment]',rate_of_interest='$_POST[rate_of_interest]',finance_by='$finance_by',payment_bank='$payment_bank',loan_ac_no='$_POST[loan_ac_no]',farm_name='$farm_name',alert_finance='$_POST[alert_finance]'";
	$db->updateTable("vehicle_registration",$string,"id='$_REQUEST[vid]'");
	
	$todate=$_POST[loan_start_date];
	
	for($i=1;$i<=$_POST[no_of_installment];$i++)
	{
	  if($i==1)
	  {
		  $next_payment_date=$_POST[loan_start_date];
	  }
	  else
	  {
		  $next_payment_date = date('Y-m-d',strtotime(date("Y-m-d", strtotime($next_payment_date)) . "+1 month"));
	  }
	  $string="vehi_id='$_REQUEST[vid]',next_payment_date='$next_payment_date',payment_status='Unpaid'";
	  $db->insertSet("installment_details",$string);
	}
}
else
{
	$string="installment_per_month='$_POST[installment_per_month]',finance_amount='$_POST[finance_amount]',interest_amount='$_POST[interest_amount]',total_amount_paid_to_bank='$_POST[total_amount_paid_to_bank]',rate_of_interest='$_POST[rate_of_interest]',finance_by='$finance_by',payment_bank='$payment_bank',loan_ac_no='$_POST[loan_ac_no]',farm_name='$farm_name',alert_finance='$_POST[alert_finance]'";
	$db->updateTable("vehicle_registration",$string,"id='$_REQUEST[vid]'");
}
header("Location:manage_vehicles.php?msg=added");
?>