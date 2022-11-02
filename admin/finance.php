<script language="javascript" type="text/javascript">
function showAddForm()
{
	$('#showform').toggle();
}

function showInstallmentPeriodDetail(fid){
	var url="show_period_detail.php";	
	$.post(url,{"fid":fid},function(res){ 						
		$("#td_showform").html(res);
	});
}
</script>

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong><a href="javascript:void(0);" title="Toggle the Unordered List." onclick="showAddForm();">ADD INSTALLMENT PERIODS</a></strong></td>
  </tr>
</table>

<br />

<?php
$per_count=1;
$inst_peri="select * from finance_details where vehicle_id='$_REQUEST[id]' order by id";
$inst_peri_row=$db->mysqli->query($inst_peri);
if($per_num=$inst_peri_row->num_rows >0) { 
?>
<table height="61" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
<thead>
<tr>
<th width="6%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
<th width="24%" align="left" valign="middle" class="fetch_headers">Vehicle No. / Type</th>

<th width="16%" align="left" valign="middle" class="fetch_headers">Loan Start Date</th>
<th width="14%" align="left" valign="middle" class="fetch_headers">Loan End Date</th>
<th width="17%" align="left" valign="middle" class="fetch_headers">Installment Amount</th>
<th width="10%" align="left" valign="middle" class="fetch_headers">No. of installment</th>
<th colspan="6" align="center" valign="middle" class="fetch_headers">Action</th>
</tr>
</thead>
<tbody>
<?php
while($inst_peri_res=$inst_peri_row->fetch_assoc()) {
$veh_det=$db->fetchSingle("vehicle_registration","id='$inst_peri_res[vehicle_id]'");
$firm = $db->strRecordID("firms", "*", "id='$veh_det[firm_name]'");
$veh_typ=$db->fetchSingle("vehicle_types","id='$veh_det[vehicle_type]'");
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($veh_det["display_no"]." / ".$veh_typ["vtype"]);?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($inst_peri_res["loan_start_date"]));  ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($inst_peri_res["loan_end_date"]));  ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($inst_peri_res["installment_per_month"],2); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $inst_peri_res["no_of_installment"]+1; ?></td>
<td width="6%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
<a href="javascript:void(0);" onClick="showInstallmentPeriodDetail(<?php echo $inst_peri_res["id"];?>);"><img src="images/view.png" width="18" height="18" title="View"></a>
</td>
</tr>
<?php $per_count+=1;} ?>
</tbody>
</table>
<?php } ?>

<div id="td_showform"></div>
<div id="showform" style="display:none;">
<?php
/*Edit Finance Information*/
if(isset($_REQUEST["fid"])){
  $res_fin=$db->fetchSingle("finance_details","id='$_REQUEST[fid]'");
}
?>
<form action="" method="post" name="frm" id="frm">
<input name="hid_action" type="hidden" value="1">
<input name="vid" type="hidden" value="<?php echo $_REQUEST['id']; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="40" colspan="5" align="left" valign="middle">
   <?php if(isset($_REQUEST["msg"]) && $_REQUEST[msg]=='added'){ ?>
   <span class="success">Record has been added successfully. </span>
  <?php } ?>
  
  <?php if(isset($_REQUEST["msg"]) && $_REQUEST[msg]=='exist'){ ?>
	<span class="success">This installment period exist. </span>
  <?php } ?>
</td>
</tr>
<tr>
<td width="17%" height="40" align="left" valign="middle">Vehicle No / Firm Name<span class="startext"></span> :</td>
<td width="19%" height="40" align="left" valign="middle" class="text25"> <?php echo strtoupper($veh_info["vehicle_no"]);?> / <?php echo strtoupper($firm["firm_name"]);?></td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="14%" height="40" align="left" valign="middle">Total amount paid to bank <span class="startext">*</span> : </td>
<td width="46%" height="40" align="left" valign="middle">
<input name="total_amount_paid_to_bank" type="text" class="validate[required] textfield121" id="total_amount_paid_to_bank" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
<td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Rate of interest <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="rate_of_interest" type="text" class="validate[required] textfield121" id="rate_of_interest" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Installment amount / month <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="installment_per_month" type="text" class="validate[required] textfield121" id="installment_per_month" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Finance By <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="finance_by" type="text" class="validate[required] textfield121" id="finance_by" style="text-transform:uppercase;"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">
Loan start date<span class="startext">*</span> :<br>
<span class="level_msg">(ex. Y-M-D) </span>
</td>
<td height="40" align="left" valign="middle">
<input name="loan_start_date" type="text" class="datepick validate[required] textfield121" id="loan_start_date" readonly/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Payment Bank<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="payment_bank" type="text" class="validate[required] textfield121" id="payment_bank" style="text-transform:uppercase;"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">
Loan end date <span class="startext">*</span> :<br>
<span class="level_msg">(ex. Y-M-D) </span>
</td>
<td height="40" align="left" valign="middle">
<input name="loan_end_date" type="text" class="datepick validate[required] textfield121" id="loan_end_date" readonly/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Loan A/C No. <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="loan_ac_no" type="text" class="validate[required] textfield121" id="loan_ac_no"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Finance amount <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="finance_amount" type="text" class="validate[required] textfield121" id="finance_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Alert Day <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="alert_finance" type="text" class="validate[required] textfield121" id="alert_finance" onKeyPress="return onlyNumbers(event);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Interest amount <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="interest_amount" type="text" class="validate[required] textfield121" id="interest_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">
<input name="farm_name" type="hidden" class="validate[required] textfield121" id="farm_name" style="text-transform:uppercase;" value="<?php echo $firm[firm_name];?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">

</td>
<td height="40" align="left" valign="middle">

</td>
</tr>
<tr>
<td height="40" colspan="5" align="left" valign="middle">
<input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
<input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="showAddForm();">
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
</tr>
</table>
</form>
</div>

<?php 
$td=date("Y-m-d");
$count=1;
$str="vehi_id='$_REQUEST[id]' order by id ASC ";
if($num=$db->countRows('installment_details',$str)> 0) {
?>
<table height="61" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
<thead>
<tr>
<th width="7%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
<th width="15%" align="left" valign="middle" class="fetch_headers">Payment due Date</th>
<th width="16%" align="left" valign="middle" class="fetch_headers">Installment Amount</th>
<th width="13%" align="left" valign="middle" class="fetch_headers">Payment Status</th>
<th width="12%" align="left" valign="middle" class="fetch_headers">Paid Date</th>
<th width="30%" align="left" valign="middle" class="fetch_headers">Remark</th>
<th colspan="5" align="center" valign="middle" class="fetch_headers">Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($db->fetchOrder("installment_details",$str,"","") as $val_inst) { 
$installment_amount_per_month=$db->fetchSingle("finance_details","id='$val_inst[finance_id]'");
if($val_inst["next_payment_date"]==$td) {  $color="#FF0000"; } else { $color=""; }
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst[id];?>">
<font color="<?php echo $color; ?>"><?php echo $count; ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_inst["next_payment_date"])); ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>">Rs. <?php echo $installment_amount_per_month["installment_per_month"]; ?></font></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">
<?php if($val_inst["payment_status"]=="Unpaid") { ?>
<select name="payment_status" class="validate[required]" id="payment_status<?php echo $val_inst["id"]; ?>" style="border:1px solid #CCC; height:25px; width:90px;">
<option value="Paid" <?php if($val_inst["payment_status"]=="Paid") { echo "Selected"; } ?>>Paid</option>
<option value="Unpaid" <?php if($val_inst["payment_status"]=="Unpaid") { echo "Selected"; } ?>>Unpaid</option>
</select>
<?php } else { ?>
<font color="#006600" style="font-weight:bold;"><?php echo strtoupper($val_inst["payment_status"]); ?></font>
<?php } ?>
</td>
<td align="left" class="fetch_contents" style="padding-left:3px;">
<?php 
if($val_inst["paid_date"]!="0000-00-00") { 
$paid_date=$val_inst["paid_date"];
}else{
 $paid_date="";
}
?>
<?php if($val_inst["payment_status"]=="Unpaid") { ?>
<input name="paid_date" type="text" class="datepick validate[required] textfield121d" id="paid_date<?php echo $val_inst["id"]; ?>" value="<?php echo $paid_date; ?>" readonly/>
<?php } else { ?>
<font color="#006600" style="font-weight:bold;"><?php echo date("jS M,Y",strtotime($paid_date)); ?></font>
<?php } ?>
</td>
<td align="left" class="fetch_contents" style="padding-left:3px;">
<?php if($val_inst["payment_status"]=="Unpaid") { ?>
<input name="remark" type="text" class="validate[required] textfield121r" id="remark<?php echo $val_inst["id"]; ?>" value="<?php echo $val_inst["remark"]; ?>" style="text-transform:uppercase;"/>
<?php } else { ?>
<?php echo strtoupper($val_inst["remark"]); ?>
<?php } ?>
</td>
<td width="7%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
<?php if($val_inst["payment_status"]=="Unpaid") { ?>
<a href="javascript:void(0);" onClick="updatePayment('<?php echo $val_inst["id"]; ?>','<?php echo $_REQUEST["id"]; ?>');">Update</a>
<?php } else { ?>
---
<?php } ?>
</td>
</tr>
<?php $count+=1;} ?>
</tbody>
</table>
<?php } ?>

