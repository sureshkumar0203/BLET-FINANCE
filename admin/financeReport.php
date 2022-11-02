<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
if(isset($_REQUEST['from_date'])){
      $frm_dt = $_REQUEST['from_date'];
    }
    else
    {
      $frm_dt = "";
    }
    if(isset($_REQUEST['to_date'])){
      $to_dt = $_REQUEST['to_date'];
    }
    else
    {
      $to_dt = "";
    }

?>
  <tr>
    <td colspan="2" align="center">
    <form action="" method="post" name="frm" id="frm">
    <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="10%" class="text1">Date from<input type="hidden" name="search" value="due_finance" id="search"></td>
    <td width="20%" class="text1"><input name="from_date" type="text" id="from_dt" class="datepick validate[required] textfield121" value="<?php echo $frm_dt; ?>" autocomplete="off"/></td>
    <td width="7%" class="text1" align="left">Date to</td>
    <td width="20%"><input name="to_date" type="text" id="to_date" class="datepick validate[required] textfield121" autocomplete="off" value="<?php echo $to_dt; ?>" /></td>
    <td width="14%" class="text1">Payment Status</td>
    <td width="14%">
    <select name="payment_status" class="validate[required]" id="payment_status" style="border:1px solid #CCC; width:100px; height:25px;" >
    <option value="Unpaid" <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Unpaid") { echo "Selected"; }?>>Unpaid</option>
    <option value="Paid" <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Paid") { echo "Selected"; }?>>Paid</option>
    <option value="" <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="") { echo "Selected"; }?>>Both</option>
    </select>
    </td>
    <td width="15%" align="left" style="padding-left:20px;"><input type="image" name="imageField" src="images/searchButton.png"></td>
    </tr>
    </table>
    </form>
</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
    <?php
	if(isset($_REQUEST['payment_status']) && $_REQUEST['search']=="due_finance")  {
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
    <td align="left" height="30" class="text1">
     Finance report from dated 
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date"]));?> </font> to
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date"])); ?></font>
    </td>
    <td align="right">
     <a href="export_finance_report.php?from_date=<?php echo $_REQUEST["from_date"];?>&to_date=<?php echo $_REQUEST["to_date"];?>&payment_status=<?php echo $_REQUEST["payment_status"];?>" class="white_heading" style="padding-right:10px;">Export to excel</a>
    </td>
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
$firm=$db->fetchSingle("firms","id='$veh_info[firm_name]'");
//Vehicle Type : Crane , Truck
$veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'"); 
if($val_inst["payment_status"]=="Paid")
{
	$bgcolor="#009966";
}
else
{
	$bgcolor="#FF0000";
}
?>
<tr>
<td height="25" align="center"><?php echo $count; ?></td>
<td style="padding-left:5px;"><a href="add_all_other_info.php?id=<?php echo $veh_info["id"];?>&#tabs-1" class="linktext"><?php echo strtoupper($veh_info["display_no"]); ?></a></td>
<td style="padding-left:5px;"><?php echo strtoupper($veh_type["vtype"]); ?></td>
<td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> <?php //echo $val_inst[vehi_id];?></td>
<td style="padding-left:5px;">
<?php if($_REQUEST["payment_status"]=="Paid") { ?> 
<?php echo date("jS M,Y",strtotime($val_inst["paid_date"])); ?> <?php } ?> 

<?php if($_REQUEST["payment_status"]=="Unpaid") { ?> 
<?php echo date("jS M,Y",strtotime($val_inst["next_payment_date"])); ?> <?php } ?> 

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
<td style="padding-left:5px;"><?php echo strtoupper($val_inst["loan_ac_no"]); ?></td>
<td style="padding-left:5px;">
<?php if($_REQUEST["payment_status"]=="Paid") { 
echo "Rs.".$val_inst["installment_per_month"]."<br>"; 
echo "Paid Through <br>".strtoupper($val_inst["remark"])."<br>"; 
}
else {
echo "Rs.".$val_inst["installment_per_month"]; 
}
?>
</td>
<td style="padding-left:5px;"><font color="<?php echo $bgcolor; ?>"><?php echo strtoupper($val_inst["payment_status"]); ?></font></td>
</tr>
<?php 
//if(is_numeric($finance_total))

$finance_total=$finance_total+$val_inst["installment_per_month"];

$count+=1;
} 
?>


<?php //if($num==0) { ?>
<tr>
<td height="25" colspan="10" align="right" class="error" style="padding-right:150px;">Total = Rs. <?php echo $finance_total; ?></td>
</tr>
<?php //} ?>
</table>
    </td>
  </tr>
<?php } else { ?>
<tr>
<td height="25" colspan="10" align="center" class="error" style="padding-right:20px;"><strong>No Results Found.</strong></td>
</tr>
<?php } ?>
<?php } ?>
</table>
