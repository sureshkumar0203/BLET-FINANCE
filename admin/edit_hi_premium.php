<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
include 'application_top.php';

//Object initialization
//$dbf = new User();

?>
<?php 
$med_pre=$db->fetchSingle("hi_premium_payment_details","id='$_REQUEST[eid]'"); 
?>
<script>	
$(document).ready(function() {
	$("#frm_edit_hi_premium").validationEngine()
});

</script>	
<form action="" method="post" name="frm_edit_hi_premium" id="frm_edit_hi_premium" enctype="multipart/form-data">
<input name="edit_hi_premium" type="hidden" value="update">
<input name="edit_id" type="hidden" value="<?php echo $med_pre["id"];?>">
<input name="policy_id" type="hidden" value="<?php echo $med_pre["policy_id"];?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;">
<tr>
<td width="16%" class="text1">Total Premium Amount</td>
<td width="16%" class="text1">Payment Date</td>
<td width="16%" class="text1">Next Premium Date</td>
<td width="16%" class="text1">Alert Day </td>
<td width="40%">&nbsp;</td>
</tr>
<tr>
<td>
<input name="total_premium_amount" type="text" class="validate[required] textfield121" id="total_premium_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $med_pre["total_premium_amount"]; ?>"/>
</td>
<td><input name="payment_date" type="text" class="datepick validate[required] textfield121" id="payment_date" autocomplete="off" readonly value="<?php echo $med_pre["payment_date"]; ?>"/> </td>
<td>
<input name="next_payment_date" type="text" class="datepick validate[required] textfield121" id="next_payment_date" autocomplete="off" value="<?php echo $med_pre["next_payment_date"]; ?>" readonly/>                      </td>
<td><input name="alert_med" type="text" class="validate[required] textfield121" id="alert_med" onKeyPress="return onlyNumbers(event);" value="<?php echo $med_pre["alert_med"]; ?>"/></td>
<td><input name="submit" type="submit" class="button" id="submit" value="Submit"></td>
</tr>
</table>
</form>