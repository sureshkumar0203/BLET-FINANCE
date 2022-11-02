<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
$pageTitle='Admin Panel';
include 'application_top.php';
//Object initialization
$dbf = new User();

/*Edit Finance Information*/
$res_fin=$dbf->fetchSingle("finance_details","id='$_REQUEST[fid]'");
$veh_info=$dbf->fetchSingle("vehicle_registration","id='$res_fin[vehicle_id]'");
$firm = $dbf->strRecordID("firms", "*", "id='$veh_info[firm_name]'");
$veh_typ=$dbf->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");
?>
<script language="javascript" type="text/javascript">
function showAddForm()
{
	$('#frm').toggle();
}
</script>
<form action="" method="post" name="frm" id="frm">
<input name="hid_action" type="hidden" value="updatePeriod">
<input name="edit_id" type="hidden" value="<?php echo $res_fin["id"]; ?>">
<input name="vid" type="hidden" value="<?php echo $res_fin["vehicle_id"]; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="40" colspan="5" align="left" valign="middle">
   <?php if(isset($_REQUEST["msg"])=='updated'){ ?>
   <span class="success">Record has been updated successfully. </span>
  <?php } ?>
</td>
</tr>
<tr>
<td width="17%" height="40" align="left" valign="middle">Vehicle No / Firm Name <span class="startext"></span> :</td>
<td width="19%" height="40" align="left" valign="middle" class="text25"> <?php echo strtoupper($veh_info["display_no"]);?> / <?php echo strtoupper($firm["firm_name"]);?> </td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="14%" height="40" align="left" valign="middle">Total amount paid to bank <span class="startext">*</span> : </td>
<td width="46%" height="40" align="left" valign="middle">
<input name="total_amount_paid_to_bank" type="text" class="validate[required] textfield121" id="total_amount_paid_to_bank" value="<?php echo $res_fin["total_amount_paid_to_bank"]; ?>" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
<td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Rate of interest <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="rate_of_interest" type="text" class="validate[required] textfield121" id="rate_of_interest" value="<?php echo $res_fin["rate_of_interest"]; ?>" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Installment amount / month <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="installment_per_month" type="text" class="validate[required] textfield121" id="installment_per_month" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_fin["installment_per_month"]; ?>"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Finance By <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="finance_by" type="text" class="validate[required] textfield121" id="finance_by" value="<?php echo $res_fin["finance_by"]; ?>" style="text-transform:uppercase;"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">
Loan start date<span class="startext">*</span> :<br>
<span class="level_msg">(ex. Y-M-D) </span>
</td>
<td height="40" align="left" valign="middle">
<?php echo date("jS M,Y",strtotime($res_fin["loan_start_date"]));  ?>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Payment Bank<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="payment_bank" type="text" class="validate[required] textfield121" id="payment_bank" value="<?php echo $res_fin["payment_bank"]; ?>" style="text-transform:uppercase;"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">
Loan end date <span class="startext">*</span> :<br>
<span class="level_msg">(ex. Y-M-D) </span>
</td>
<td height="40" align="left" valign="middle">
<?php echo date("jS M,Y",strtotime($res_fin["loan_end_date"]));  ?>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Loan A/C No. <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="loan_ac_no" type="text" class="validate[required] textfield121" id="loan_ac_no" value="<?php echo $res_fin["loan_ac_no"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Finance amount <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="finance_amount" type="text" class="validate[required] textfield121" id="finance_amount" value="<?php echo $res_fin["finance_amount"]; ?>" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Alert Day <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="alert_finance" type="text" class="validate[required] textfield121" id="alert_finance" value="<?php echo $res_fin["alert_finance"]; ?>" onKeyPress="return onlyNumbers(event);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Interest amount <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="interest_amount" type="text" class="validate[required] textfield121" id="interest_amount" value="<?php echo $res_fin["interest_amount"]; ?>" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">
<input name="farm_name" type="hidden" class="validate[required] textfield121" id="farm_name" value="<?php echo $veh_info["firm_name"]; ?>" style="text-transform:uppercase;"/>
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



