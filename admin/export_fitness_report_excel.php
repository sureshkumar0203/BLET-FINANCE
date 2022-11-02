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
//Fitness reminder starts here
$fit_count=1;
if($_REQUEST["fit_status"]=="tobepaid") 
  {
    $sql_fit_rem="SELECT * from  fitness_details where fitness_to_dt between '".$_REQUEST['from_date_fitness']."' AND '".$_REQUEST['to_date_fitness']."' order by fitness_to_dt";
  }
  if($_REQUEST["fit_status"]=="paid") 
  {
    $sql_fit_rem="SELECT * from  fitness_details where date_of_payment between '".$_REQUEST['from_date_fitness']."' AND '".$_REQUEST['to_date_fitness']."' order by date_of_payment";
  }
  if($_REQUEST["fit_status"]=="both")
  {
    $sql_fit_rem="SELECT * from fitness_details where (fitness_to_dt between '".$_REQUEST['from_date_fitness']."' AND '".$_REQUEST['to_date_fitness']."') OR (date_of_payment between '".$_REQUEST['from_date_fitness']."' AND '".$_REQUEST['to_date_fitness']."') order by date_of_payment,fitness_to_dt";
  }
//echo $sql_fit_rem;

$sql_fit_rem_row=$db->mysqli->query($sql_fit_rem);
$fit_num=$sql_fit_rem_row->num_rows;
if($fit_num!=0) { 
?>
<tr>
<td class="text1" align="left" height="40" valign="top">
Fitness report from dated 
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date_fitness"]));?> </font> to
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date_fitness"])); ?></font>
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
  <?php if($_REQUEST["fit_status"]=="tobepaid") { ?>Due Date <?php } ?>
  <?php if($_REQUEST["fit_status"]=="paid") { ?>Payment Detail<?php } ?>
  <?php if($_REQUEST["fit_status"]=="both") { ?>Payment Status<?php } ?>
  </td>
  <td width="20%" style="padding-left:5px;">RTO Office</td>
  <td width="12%" style="padding-left:5px;">Amount</td>
  </tr>
  <?php
  $fitness_total=0;
  while($val_fit=$sql_fit_rem_row->fetch_assoc()) {
	  $veh_info_fit=$db->fetchSingle("vehicle_registration","id='$val_fit[vehicle_id]'");
	  $firm = $db->strRecordID("firms", "*", "id='$veh_info_fit[firm_name]'");
  	 //Vehicle Type : Crane , Truck
  	 $veh_type_fit=$db->fetchSingle("vehicle_types","id='$veh_info_fit[vehicle_type]'"); 
	   $rto = $db->strRecordID("rto_office" , "*", "id='$veh_info_fit[rto_office]'");
  ?>
  <tr>
  <td height="25" align="center"><?php echo $fit_count; ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($veh_info_fit["display_no"]); ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($veh_type_fit["vtype"]); ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
  <td style="padding-left:5px;">
  <?php if(isset($_REQUEST["fit_status"])=="tobepaid") { ?><?php echo date("jS M,Y",strtotime($val_fit["fitness_to_dt"])); ?><?php } ?>
  
  <?php if(isset($_REQUEST["fit_status"])=="paid") { ?>
  <?php echo date("jS M,Y",strtotime($val_fit["date_of_payment"])); ?><br />
  <?php echo $val_fit["mode_of_payment"]; ?><br />
  <?php echo $val_fit["cheque_no"]; ?>
  <?php } ?>
  
  <?php if($_REQUEST["fit_status"]=="both") { ?>
  
  <?php if($val_fit["date_of_payment"]!="0000-00-00") { ?>
  <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_fit["date_of_payment"])); ?> <?php } ?></font>
  <?php if($val_fit["date_of_payment"]=="0000-00-00") { ?>
  <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_fit["fitness_to_dt"])); ?></b></font>
  <?php } ?>
  
  <?php } ?>
  
  </td>
  <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
  <td style="padding-left:5px;"><?php echo $val_fit["fitness_amount"]; ?></td>
  </tr>
  <?php 
  $fitness_total=$fitness_total+$val_fit["fitness_amount"];
  $fit_count+=1;} ?>
  <tr>
  <td height="25" colspan="7" align="right" class="error" style="padding-right:85px;">Total = Rs. <?php echo $fitness_total; ?></td>
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