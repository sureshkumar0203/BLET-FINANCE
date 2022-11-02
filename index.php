<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';
$pageTitle='DASHBOARD';
//Object initialization
$dbf = new User();
$db = new Dbfunctions();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BLE FINANCE</title>
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {
	font-family: Algerian;
	color: #E8E8E8;
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="1100" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background: url(images/top_bg.jpg) repeat-x;">
  <tr>
 
    <td width="50%" height="90" align="left" valign="middle" style="padding-left:23px;">
    <h1><a href="index.php" class="style3" style="text-decoraon:none;">BLE FINANCE REMINDER</a></h1></td>
    <td width="50%" align="right" valign="top" style="padding-right:5px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="middle" class="greenborder" >&nbsp;</td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td height="440" valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="7" colspan="3"></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <?php
     $count=1;
	 $sql="SELECT f.*,i.* FROM finance_details f Inner join installment_details i on f.vehicle_id=i.vehi_id where next_payment_date between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval f.alert_finance day) AND i.payment_status='Unpaid' group by f.vehicle_id  order by i.next_payment_date";
	  $sql_row=$db->mysqli->query($sql);
	  $num=$sql_row->num_rows;
	  if($num!=0) { 
  ?>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle" class="white_heading" height="35" bgcolor="#0099FF"><font color="#FFFFFF">FINANCE</font></td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td width="1055" align="left" valign="top" height="35" style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="2%" align="center">SL</td>
        <td width="9%" height="30" style="padding-left:5px;">Vehicle No.</td>
        <td width="10%" height="30" style="padding-left:5px;">Vehicle Type</td>
        <td width="15%" height="30" style="padding-left:5px;">Firm Name</td>
        <td width="14%" height="30" style="padding-left:5px;">Due Date</td>
        <td width="9%" height="30" style="padding-left:5px;">Finance By</td>
        <td width="13%" height="30" style="padding-left:5px;">Payment Bank</td>
        <td width="18%" height="30" style="padding-left:5px;">Loan A/C No.</td>
        <td width="10%" height="30" style="padding-left:5px;">Installment Amount</td>
      </tr>
       <?php
	   while($val_inst= $sql_row->fetch_assoc()){ 
       
	   $veh_info=$db->fetchSingle("vehicle_registration","id='$val_inst[vehi_id]'");
       //Vehicle Type : Crane , Truck
        $veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'"); 
       ?>
      <tr>
        <td height="25" align="center"><?php echo $count; ?></td>
        <td style="padding-left:5px;"><?php  echo strtoupper($veh_info["display_no"]);  ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_type["vtype"]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_inst["farm_name"]); ?> </td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_inst["next_payment_date"])); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_inst["finance_by"]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_inst["payment_bank"]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_inst["loan_ac_no"]); ?></td>
        <td style="padding-left:5px;">Rs. <?php echo $val_inst["installment_per_month"]; ?></td>
      </tr>
      <?php $count+=1;} ?>
  
  
       <?php if($num==0) { ?>
      <tr>
        <td height="25" colspan="9" align="center" class="error">No Finance Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
  
    </td>
    <td>&nbsp;</td>
  </tr>
   <?php } ?>


  <?php
  //Insurance Reminder starts from here
    $ins_count=1;
   $sql_ins_rem="SELECT * from insurance_details where insurance_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_insurance day) order by insurance_to_dt";
   $sql_ins_rem_row=$db->mysqli->query($sql_ins_rem);
   $ins_num=$sql_ins_rem_row->num_rows;
   if($ins_num!=0) { 
  ?>
    
   <tr>
    <td width="10">&nbsp;</td>
    <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF">INSURANCE</font></td>
    </tr>
 
  <tr>
    <td width="10">&nbsp;</td>
    <td style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="10%" height="30" style="padding-left:5px;">Vehicle No.</td>
        <td width="11%" style="padding-left:5px;">Vehicle Type</td>
        <td width="17%" height="30" style="padding-left:5px;">Firm Name </td>
        <td width="16%" height="30" style="padding-left:5px;">Due Date</td>
        <td width="23%" style="padding-left:5px;">Insurance Company</td>
        <td width="20%" style="padding-left:5px;">Amount</td>
      </tr>
       <?php
	   while($val_ins=$sql_ins_rem_row->fetch_assoc()) {
	    $veh_info_ins=$db->fetchSingle("vehicle_registration","id='$val_ins[vehicle_id]'");
       //Vehicle Type : Crane , Truck
        $veh_type_ins=$db->fetchSingle("vehicle_types","id='$veh_info_ins[vehicle_type]'"); 
       ?>
      <tr>
        <td height="25" align="center"><?php echo $ins_count; ?></td>
        <td style="padding-left:5px;"><?php  echo strtoupper($veh_info_ins["display_no"]);  ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_type_ins["vtype"]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_info_ins["firm_name"]); ?> </td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_ins["insurance_to_dt"])); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_ins["insurance_company_name"]); ?></td>
        <td style="padding-left:5px;">Rs. <?php echo $val_ins["total"]; ?></td>
      </tr>
      <?php $ins_count+=1;} ?>
       <?php if($ins_num==0) { ?>
      <tr>
        <td height="25" colspan="7" align="center" class="error">No Other Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
    </td>
    <td width="14">&nbsp;</td>
  </tr>
  <?php } ?>
  
  
    <?php
	//Road tax reminder starts here
	$tax_count=1;
    //$sql_tax_rem="select * from roadtax_details where alert_tax in (SELECT alert_tax from roadtax_details where tax_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_tax day))";
	
   $sql_tax_rem="SELECT * from roadtax_details where tax_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_tax day) order by tax_to_dt";
   $sql_tax_rem_row=$db->mysqli->query($sql_tax_rem);
   $tax_num=$sql_tax_rem_row->num_rows;
   if($tax_num!=0) { 
  ?>
  <tr>
    <td>&nbsp;</td>
    <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF">ROAD TAX</font></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="10">&nbsp;</td>
    <td style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="10%" height="30" style="padding-left:5px;">Vehicle No.</td>
        <td width="11%" style="padding-left:5px;">Vehicle Type</td>
        <td width="17%" height="30" style="padding-left:5px;">Firm Name</td>
        <td width="16%" height="30" style="padding-left:5px;">Due Date</td>
        <td width="23%" style="padding-left:5px;">RTO Office</td>
        <td width="" style="padding-left:5px;">Amount</td>
      </tr>
       <?php
	   while($val_tax=$sql_tax_rem_row->fetch_assoc()) {
	    $veh_info_tax=$db->fetchSingle("vehicle_registration","id='$val_tax[vehicle_id]'");
       //Vehicle Type : Crane , Truck
        $veh_type_tax=$db->fetchSingle("vehicle_types","id='$veh_info_tax[vehicle_type]'"); 
       ?>
      <tr>
        <td height="25" align="center"><?php echo $tax_count; ?></td>
        <td style="padding-left:5px;"><?php  echo strtoupper($veh_info_tax["display_no"]);  ?><?php //echo $veh_info_tax[vehicle_no]; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_type_tax["vtype"]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_info_tax["firm_name"]); ?></td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_info_tax["rto_office"]); ?></td>
        <td style="padding-left:5px;">Rs. <?php echo $val_tax["total"]; ?></td>

      </tr>
      <?php $tax_count+=1;} ?>
       <?php if($tax_num==0) { ?>
      <tr>
        <td height="25" colspan="7" align="center" class="error">No Other Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
    </td>
    <td width="14">&nbsp;</td>
  </tr>

  
  <?php } ?>
  
  
  
    <?php
	//Fitness reminder starts here
	$fit_count=1;
    //$sql_fit_rem="select * from  fitness_details where alert_fitness  in(SELECT alert_fitness from  fitness_details where fitness_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_fitness day))";
	
	 $sql_fit_rem="SELECT * from  fitness_details where fitness_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_fitness day) order by fitness_to_dt";
	 $sql_fit_rem_row=$db->mysqli->query($sql_fit_rem);
	 $fit_num=$sql_fit_rem_row->num_rows;
	 if($fit_num!=0) { 
   ?>
  <tr>
    <td>&nbsp;</td>
    <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF">FITNESS</font></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="10">&nbsp;</td>
    <td style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="10%" height="30" style="padding-left:5px;">Vehicle No.</td>
        <td width="11%" style="padding-left:5px;">Vehicle Type</td>
        <td width="17%" height="30" style="padding-left:5px;">Firm Name</td>
        <td width="16%" height="30" style="padding-left:5px;">Due Date</td>
        <td width="23%" style="padding-left:5px;">RTO Office</td>
        <td width="" style="padding-left:5px;">Amount</td>
      </tr>
       <?php
	   while($val_fit=$sql_fit_rem_row->fetch_assoc()) {
	    $veh_info_fit=$db->fetchSingle("vehicle_registration","id='$val_fit[vehicle_id]'");
       //Vehicle Type : Crane , Truck
        $veh_type_fit=$db->fetchSingle("vehicle_types","id='$veh_info_fit[vehicle_type]'"); 
       ?>
      <tr>
        <td height="25" align="center"><?php echo $fit_count; ?></td>
        <td style="padding-left:5px;"><?php  echo strtoupper($veh_info_fit["display_no"]);  ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_type_fit["vtype"]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_info_fit["firm_name"]); ?></td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_fit["fitness_to_dt"])); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_info_fit["rto_office"]); ?></td>
        <td style="padding-left:5px;">Rs. <?php echo $val_fit["fitness_amount"]; ?></td>
      </tr>
      <?php $fit_count+=1;} ?>
       <?php if($fit_num==0) { ?>
      <tr>
        <td height="25" colspan="7" align="center" class="error">No Other Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
    </td>
    <td width="14">&nbsp;</td>
  </tr>
  
  <?php } ?>
  
  
  
   <?php
	//Permit reminder starts here
	$per_count=1;
	$sql_per_rem="SELECT * from  permit_details where permit_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_permit day) order by permit_to_dt";
   $sql_per_rem_row=$db->mysqli->query($sql_per_rem);
   $per_num=$sql_per_rem_row->num_rows;
   if($per_num!=0) { 
  ?>
  <tr>
    <td>&nbsp;</td>
    <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF">PERMIT</font></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="10">&nbsp;</td>
    <td style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="10%" height="30" style="padding-left:5px;">Vehicle No.</td>
        <td width="11%" style="padding-left:5px;">Vehicle Type</td>
        <td width="17%" height="30" style="padding-left:5px;">Firm Name</td>
        <td width="16%" height="30" style="padding-left:5px;">Due Date</td>
        <td width="23%" style="padding-left:5px;">RTO Office</td>
        <td width="" style="padding-left:5px;">Amount</td>
      </tr>
       <?php
	   while($val_per=$sql_per_rem_row->fetch_assoc()) {
	    $veh_info_per=$db->fetchSingle("vehicle_registration","id='$val_per[vehicle_id]'");
       //Vehicle Type : Crane , Truck
        $veh_type_per=$db->fetchSingle("vehicle_types","id='$veh_info_per[vehicle_type]'"); 
       ?>
      <tr>
        <td height="25" align="center"><?php echo $per_count; ?></td>
        <td style="padding-left:5px;"><?php  echo strtoupper($veh_info_per['display_no']);  ?> <?php //echo $veh_info_per[vehicle_no]; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_type_per['vtype']); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_info_per['firm_name']); ?></td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_per['permit_to_dt'])); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_info_per['rto_office']); ?></td>
        <td style="padding-left:5px;">Rs. <?php echo $val_per['permit_amount']; ?></td>
      </tr>
      <?php $per_count+=1;} ?>
       <?php if($per_num==0) { ?>
      <tr>
        <td height="25" colspan="7" align="center" class="error">No Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
    </td>
    <td width="14">&nbsp;</td>
  </tr>
  
  <?php } ?>
  
  
     <?php
	//DL reminder starts here
	$dl_count=1;
	$sql_dl_rem="SELECT * from  driving_licence where 	valid_till between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_licence day) order by valid_till";
    $sql_dl_rem_row=$db->mysqli->query($sql_dl_rem);
    $dl_num=$sql_dl_rem_row->num_rows;
    if($dl_num!=0) { 
  ?>
  <tr>
    <td>&nbsp;</td>
    <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF">DL</font></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="10">&nbsp;</td>
    <td style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="21%" height="30" style="padding-left:5px;">Driver Name </td>
        <td width="13%" style="padding-left:5px;">Contact No.</td>
        <td width="21%" height="30" style="padding-left:5px;">DL NO.</td>
        <td width="13%" height="30" style="padding-left:5px;">Expire Date</td>
        <td width="13%" style="padding-left:5px;">Referred by</td>
        <td width="" style="padding-left:5px;">Referer Mobile No</td>
      </tr>
       <?php
	   while($val_dl=$sql_dl_rem_row->fetch_assoc()) {
       ?>
      <tr>
        <td height="25" align="center"><?php echo $dl_count; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_dl[first_name]." ".$val_dl[middle_name]." ".$val_dl[last_name]); ?></td>
        <td style="padding-left:5px;"><?php echo $val_dl[contact_no]; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_dl[dl_no]); ?></td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_dl[valid_till])); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($val_dl[referred_by]); ?></td>
        <td style="padding-left:5px;"><?php echo $val_dl[referer_mob_no]; ?></td>
      </tr>
      <?php $dl_count+=1;} ?>
       <?php if($dl_num==0) { ?>
      <tr>
        <td height="25" colspan="7" align="center" class="error">No Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
    </td>
    <td width="14">&nbsp;</td>
  </tr>
  
  <?php } ?>
  
  
 <!-- LIC Premium-->
   <?php
   $pre_count=1;
   $sql_pre_rem="SELECT * from premium_payment_details where next_payment_date between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_lic day) order by next_payment_date";
   $sql_pre_rem_row=$db->mysqli->query($sql_pre_rem);
   $pre_num=$sql_pre_rem_row->num_rows;
   if($pre_num!=0) { 
  ?>
  <tr>
    <td>&nbsp;</td>
    <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF">LIC Premium</font></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="10">&nbsp;</td>
    <td style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="21%" height="30" style="padding-left:5px;">Policy holder Name </td>
        <td width="17%" style="padding-left:5px;">Policy No.</td>
        <td width="16%" height="30" style="padding-left:5px;">Due Date </td>
        <td width="14%" height="30" style="padding-left:5px;">Agent Contact No.</td>
        <td width="9%" style="padding-left:5px;">Agent Name</td>
        <td width="20%" style="padding-left:5px;">Amount</td>
      </tr>
	   <?php
	    while($val_premium=$sql_pre_rem_row->fetch_assoc()) {
		$premium_info=$db->fetchSingle("lic_registration","id='$val_premium[policy_id]'");
       ?>
      <tr>
        <td height="25" align="center"><?php echo $pre_count; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($premium_info[name_policy_holder]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($premium_info[policy_no]); ?></td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_premium[next_payment_date])); ?></td>
        <td style="padding-left:5px;"><?php echo $premium_info[agent_contact_no]; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($premium_info[name_agent]); ?></td>
        <td style="padding-left:5px;">Rs. <?php echo $val_premium[premium_amount]; ?></td>
      </tr>
      <?php $pre_count+=1;} ?>
       <?php if($pre_num==0) { ?>
      <tr>
        <td height="25" colspan="7" align="center" class="error">No Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
    </td>
    <td width="14">&nbsp;</td>
  </tr>
  
  <?php } ?>
  
  
   <!-- Health Insurance Premium-->
   <?php
   $hi_pre_count=1;
   $sql_hi_pre_rem="SELECT * from hi_premium_payment_details where next_payment_date between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_med day) order by next_payment_date";
   $sql_hi_pre_rem_row=$db->mysqli->query($sql_hi_pre_rem);
   $hi_pre_num=$sql_hi_pre_rem_row->num_rows;
   if($hi_pre_num!=0) { 
  ?>
  <tr>
    <td>&nbsp;</td>
    <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF">Health Insurance Premium</font></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="10">&nbsp;</td>
    <td style="padding-top:0px; padding-bottom:10px;">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
      <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="21%" height="30" style="padding-left:5px;">Policy holder Name </td>
        <td width="33%" style="padding-left:5px;">Policy No.</td>
        <td width="24%" height="30" style="padding-left:5px;">Due Date </td>
        <td width="19%" style="padding-left:5px;">Amount</td>
      </tr>
	   <?php
	    while($val_hi_premium=$sql_hi_pre_rem_row->fetch_assoc()) {
		$hi_premium_info=$db->fetchSingle("mediclaim_registration","id='$val_hi_premium[policy_id]'");
       ?>
      <tr>
        <td height="25" align="center"><?php echo $hi_pre_count; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($hi_premium_info[policy_holder_name]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($hi_premium_info[policy_no]); ?></td>
        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_hi_premium[next_payment_date])); ?></td>
        <td style="padding-left:5px;">Rs. <?php echo $val_hi_premium[total_premium_amount]; ?></td>
      </tr>
      <?php $hi_pre_count+=1;} ?>
       <?php if($hi_pre_num==0) { ?>
      <tr>
        <td height="25" colspan="5" align="center" class="error">No Reminder Available.</td>
        </tr>
       <?php } ?>
    </table>
    </td>
    <td width="14">&nbsp;</td>
  </tr>
  
  <?php } ?>
  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php if($num==0 && $ins_num==0 && $tax_num==0 && $fit_num==0 && $per_num==0 && $dl_num==0) { ?>
  <tr>
    <td>&nbsp;</td>
    <td align="center" class="error"><font color="#FF0000" size="+4">No Results Found</font></td>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table></td>
  </tr>
<tr>
    <td align="center" valign="middle" class="footer"><span class="footertext">Copyright &copy; <?php echo date("Y");?> All Rights Reserved.</span></td>
  </tr>
</table>

</body>
</html>
