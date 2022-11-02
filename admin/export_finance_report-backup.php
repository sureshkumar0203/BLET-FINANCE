<?php

ob_start();

session_start();

include_once '../includes/class.Main.php';



//Object initialization

$dbf = new User();

if($_REQUEST[payment_status]!="")
{
	$sql="SELECT (select display_no from vehicle_registration where id=f.vehicle_id) as 'Vehichle No',(select vtype from vehicle_types where id in (select vehicle_type from vehicle_registration where id=f.vehicle_id)) as 'Vehicle Type',(select farm_name from vehicle_registration where id=f.vehicle_id) as 'Firm Name',i.next_payment_date 'Due Date',i.paid_date 'Paid Date',i.paid_date 'Paid Date',f.finance_by 'Finance By',f.payment_bank 'Payment Bank',f.loan_ac_no 'Loan A/C No.',f.installment_per_month 'Installment Amount',i.payment_status 'Payment Status' FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND i.next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]' AND i.payment_status='$_REQUEST[payment_status]'";
}
else
{
	$sql="SELECT (select display_no from vehicle_registration where id=f.vehicle_id) as 'Vehichle No',(select vtype from vehicle_types where id in (select vehicle_type from vehicle_registration where id=f.vehicle_id)) as 'Vehicle Type',(select farm_name from vehicle_registration where id=f.vehicle_id) as 'Firm Name',i.next_payment_date 'Due Date',i.paid_date 'Paid Date',f.finance_by 'Finance By',f.payment_bank 'Payment Bank',f.loan_ac_no 'Loan A/C No.',f.installment_per_month 'Installment Amount',i.payment_status 'Payment Status' FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND i.next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]' AND (i.payment_status='Paid' || i.payment_status='Unpaid')";
}
	
$qry = mysql_query($sql) or die(mysql_error());
$out = '';
$columns = mysql_num_fields($qry);

// Put the name of all fields

for ($i = 0; $i < $columns; $i++) {
$l=mysql_field_name($qry, $i);
$out .= '"'.$l.'",';
}



$out .="\n";



// Add all values in the table



while ($l = mysql_fetch_array($qry)) {



for ($i = 0; $i < $columns; $i++) {



$out .='"'.$l["$i"].'",';



}



$out .="\n";



}



// Output to browser with appropriate mime type, you choose ;)



header("Content-type: text/x-csv");



//header("Content-type: text/csv");



//header("Content-type: application/csv");



header("Content-Disposition: attachment; filename=Order.csv");



echo $out;



exit;





?>