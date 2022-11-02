<?php
ob_start();
//session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//Object initialization
//$dbf = new User();
?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
//Insurance Reminder starts from here
$ins_count=1;
if(isset($_REQUEST["status"]) &&  $_REQUEST["status"]=="tobepaid")
  {
    $sql_ins_rem="SELECT * from insurance_details where insurance_to_dt between '$_REQUEST[from_date_ins]' AND '$_REQUEST[to_date_ins]' order by insurance_to_dt";
  }
  if(isset($_REQUEST["status"]) &&  $_REQUEST['status']=="paid")
  {
    $sql_ins_rem="SELECT * from insurance_details where date_of_payment between '$_REQUEST[from_date_ins]' AND '$_REQUEST[to_date_ins]' order by date_of_payment";
  }
  if(isset($_REQUEST["status"]) &&  $_REQUEST['status']=="both")
  {
    $sql_ins_rem="SELECT * from insurance_details where (insurance_to_dt between '$_REQUEST[from_date_ins]' AND '$_REQUEST[to_date_ins]') OR (date_of_payment between '$_REQUEST[from_date_ins]' AND '$_REQUEST[to_date_ins]') order by date_of_payment,insurance_to_dt";
  }
//echo $sql_ins_rem;
$sql_ins_rem_row=$db->mysqli->query($sql_ins_rem);
$ins_num=$sql_ins_rem_row->num_rows;
if($ins_num!=0) { 
?>
<tr>
<td class="text1" align="left" height="40" valign="top">
Insurance report from dated 
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date_ins"]));?> </font> to
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date_ins"])); ?></font>
</td>
<td class="white_heading" align="right">&nbsp;</td>
</tr>

<tr>
<td colspan="2">
  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
  <tr bgcolor="#999999" class="text1">
  <td width="3%" align="center">SL</td>
  <td width="13%" height="30" style="padding-left:5px;">Vehicle No.</td>
  <td width="11%" style="padding-left:5px;">Vehicle Type</td>
  <td width="20%" height="30" style="padding-left:5px;">Firm Name </td>
  <td width="21%" height="30" style="padding-left:5px;">
  <?php if(isset($_REQUEST["status"])=="tobepaid") { ?>Due Date <?php } ?>
  <?php if(isset($_REQUEST["status"])=="paid") { ?>Payment Detail<?php } ?>
  <?php if(isset($_REQUEST["status"])=="both") { ?>Payment Detail<?php } ?>
  </td>
  <td width="20%" style="padding-left:5px;">Insurance Company</td>
  <td width="12%" style="padding-left:5px;">Amount</td>
  </tr>
  <?php
  $ins_tot=0;
  while($val_ins=$sql_ins_rem_row->fetch_assoc()) {
	  $veh_info_ins=$db->fetchSingle("vehicle_registration","id='$val_ins[vehicle_id]'");
	  $firm = $db->strRecordID("firms", "*", "id='$veh_info_ins[firm_name]'");
	  //Vehicle Type : Crane , Truck
	  $veh_type_ins=$db->fetchSingle("vehicle_types","id='$veh_info_ins[vehicle_type]'");
  
  ?>
  <tr>
  <td height="25" align="center"><?php echo $ins_count; ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($veh_info_ins["display_no"]); ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($veh_type_ins["vtype"]); ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
  <td style="padding-left:5px;">
  <?php if(isset($_REQUEST["status"])=="tobepaid") { ?> <?php echo date("jS M,Y",strtotime($val_ins["insurance_to_dt"])); ?> <?php } ?>
  
  <?php if(isset($_REQUEST["status"])=="paid") { ?>
  <font color="#009900"><?php echo date("jS M,Y",strtotime($val_ins["date_of_payment"])); ?></font><br />
  <?php echo $val_ins["mode_of_payment"]; ?><br />
  <?php echo $val_ins["cheque_no"]; ?>
  <?php } ?>
  
  <?php if(isset($_REQUEST["status"])=="both") { ?>
  
  <?php if($val_ins["date_of_payment"]!="0000-00-00") { ?>
  <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_ins["date_of_payment"])); ?> <?php } ?></font>
  <?php if($val_ins["date_of_payment"]=="0000-00-00") { ?>
  <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_ins["insurance_to_dt"])); ?></b></font>
  <?php } ?>
  
  <?php } ?>
  
  </td>
  <td style="padding-left:5px;"><?php echo strtoupper($val_ins["insurance_company_name"]); ?></td>
  <td style="padding-left:5px;"><?php echo $val_ins["total"]; ?></td>
  </tr>
  <?php
  $ins_count=$ins_count+1;
  $ins_tot=$ins_tot+$val_ins["total"];
  }
  ?>
  
  <tr>
  <td height="25" colspan="7" align="right" class="error" style="padding-right:85px;">Total = Rs. <?php echo $ins_tot; ?></td>
  </tr>
  
  </table>
</td>
</tr>
<?php } else { ?>
<tr>
<td height="25" colspan="10" align="center" class="error" style="padding-right:20px;"><strong>No Results Found.</strong></td>
</tr>
<?php } ?>

</table>