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
$count=1;
if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Paid")
  {
    $sql="SELECT f.*,i.* FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND i.next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]' AND i.payment_status='Paid' group by f.vehicle_id  order by i.paid_date" ;
  }
  if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Unpaid")
  {
    $sql="SELECT f.*,i.* FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND i.next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]' AND i.payment_status='Unpaid' group by f.vehicle_id  order by i.next_payment_date" ;
  }
  
  if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="")
  {
    $sql="SELECT f.*,i.* FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]'";
  }
//echo $sql;
$sql_row=$db->mysqli->query($sql);
$num=$sql_row->num_rows;
if($num!=0) { 
?>

<tr>
<td align="left" height="40" class="text1" valign="top">
Finance report from dated 
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date"]));?> </font> to
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date"])); ?></font>
</td>
<td align="right">&nbsp;</td>
</tr>

<tr>
<td colspan="2">
  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
    <tr bgcolor="#999999" class="text1">
    <td width="3%" align="center">SL</td>
    <td width="11%" height="30" style="padding-left:5px;">Vehicle No.</td>
    <td width="10%" height="30" style="padding-left:5px;">Vehicle Type</td>
    <td width="9%" height="30" style="padding-left:5px;">Firm Name</td>
    <td width="13%" height="30" style="padding-left:5px;"><?php if($_REQUEST["payment_status"]=="Paid") { ?> Paid Date <?php } ?> <?php if($_REQUEST["payment_status"]=="Unpaid") { ?> Due Date <?php } ?> <?php if($_REQUEST["payment_status"]=="") { ?> Both <?php } ?></td>
    <td width="11%" height="30" style="padding-left:5px;">Finance By</td>
    <td width="12%" height="30" style="padding-left:5px;">Payment Bank</td>
    <td width="13%" height="30" style="padding-left:5px;">Loan A/C No.</td>
    <td width="10%" height="30" style="padding-left:5px;">
    <?php if($_REQUEST["payment_status"]=="Paid") { ?> Paid Amount <?php } ?> <?php if($_REQUEST["payment_status"]=="Unpaid") { ?> Installment Amount <?php } ?> <?php if($_REQUEST["payment_status"]=="") { ?> Amount <?php } ?>
    </td>
    <td width="8%" style="padding-left:5px;">Payment Status</td>
    </tr>
  <?php
  $finance_total=0;
  while($val_inst=$sql_row->fetch_assoc()) {
	  $veh_info=$db->fetchSingle("vehicle_registration","id='$val_inst[vehi_id]'");
	  //Vehicle Type : Crane , Truck
	  $veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'"); 
	  if(isset($val_inst["payment_status"])=="Paid") {
		  $bgcolor="#009966";
	  } else {
		  $bgcolor="#FF0000";
	  }
  ?>
  <tr>
  <td height="25" align="center"><?php echo $count; ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($veh_info["display_no"]); ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($veh_type["vtype"]); ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($val_inst["farm_name"]); ?> </td>
  <td style="padding-left:5px;">
  <?php if($_REQUEST["payment_status"]=="Paid") { ?> <?php echo date("jS M,Y",strtotime($val_inst["paid_date"])); ?> <?php } ?> 
  
  <?php if($_REQUEST["payment_status"]=="Unpaid") { ?> <?php echo date("jS M,Y",strtotime($val_inst["next_payment_date"])); ?> <?php } ?> 
  
  <?php 
  if($_REQUEST["payment_status"]=="") {   
  if($val_inst["payment_status"]=="Paid") { 
  ?>
  
  <?php //echo "<font color='#FF0000'>".date("jS M,Y",strtotime($val_inst[next_payment_date]))."</font><br>"; ?>
  <?php echo "<font color='#009933'>".date("jS M,Y",strtotime($val_inst["paid_date"]))."</font>"; ?>
  <?php } else { ?>
  <?php echo "<font color='#FF0000'><b>".date("jS M,Y",strtotime($val_inst["next_payment_date"]))."</b></font>"; ?>
  <?php } ?>
  <?php } ?>
  
  </td>
  <td style="padding-left:5px;"><?php echo strtoupper($val_inst["finance_by"]); ?></td>
  <td style="padding-left:5px;"><?php echo strtoupper($val_inst["payment_bank"]); ?></td>
  <td style="padding-left:5px;" align="left"><?php echo strtoupper($val_inst["loan_ac_no"]); ?></td>
  <td style="padding-left:5px;">
  
  <?php if(isset($_REQUEST["payment_status"])=="Paid") { 
  echo $val_inst["installment_per_month"]."<br>"; 
  echo "Paid Through <br>".strtoupper($val_inst["remark"])."<br>"; 
  } else { echo $val_inst["installment_per_month"]; }
  ?>
  </td>
  <td style="padding-left:5px;"><font color="<?php echo $bgcolor; ?>"><?php echo strtoupper($val_inst["payment_status"]); ?></font></td>
  </tr>
  <?php 
  $finance_total=$finance_total+$val_inst["installment_per_month"];
  $count+=1;
  } 
  ?>
  
  <tr>
  <td height="25" colspan="10" align="right" class="error" style="padding-right:180px;">Total = Rs. <?php echo $finance_total; ?></td>
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