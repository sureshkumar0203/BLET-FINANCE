<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include 'application_top.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//Object initialization
//$dbf = new User();

?>
<?php 
$lic_pre=$db->fetchSingle("premium_payment_details","id='$_REQUEST[eid]'"); 
?>
<script>	
$(document).ready(function() {
	$("#frm_edit_premium").validationEngine()
});

</script>	
<link href="css/style.css" rel="stylesheet" type="text/css" />
<form action="" method="post" name="frm_edit_premium" id="frm_edit_premium" enctype="multipart/form-data">
<input name="edit_premium" type="hidden" value="update">
<input type="hidden" name="premium_mode" id="premium_mode" value="<?php echo $lic_pre["premium_mode"]; ?>" />
<input name="edit_id" type="hidden" value="<?php echo $lic_pre["id"];?>">
<input name="policy_id" type="hidden" value="<?php echo $lic_pre["policy_id"];?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;">
<tr>
<td width="9%" class="text1">Premium Amount</td>
<td width="10%" class="text1">Payment Date</td>
<td width="11%" class="text1">Next Premium Date</td>
<td width="10%" class="text1">Alert Day </td>
<td width="12%" align="left" valign="middle" class="text1">Payment Mode</td>
<td width="21%" align="left" valign="middle" class="text1">&nbsp;</td>
<td width="18%">&nbsp;</td>
<td width="9%">&nbsp;</td>
</tr>
<tr>
<td>
<input name="premium_amount" type="text" class="validate[required] textfield121d" id="premium_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $lic_pre["premium_amount"]; ?>"/>
</td>
<td><input name="payment_date" type="text" class="datepick validate[required] textfield121d" id="payment_date" autocomplete="off" readonly value="<?php echo $lic_pre["payment_date"]; ?>"/> </td>
<td>
<input name="next_payment_date" type="text" class="datepick validate[required] textfield121d" id="next_payment_date" autocomplete="off" value="<?php echo $lic_pre["next_payment_date"]; ?>" readonly/>                      </td>
<td><input name="alert_lic" type="text" class="validate[required] textfieldsmall" id="alert_lic" onKeyPress="return onlyNumbers(event);" value="<?php echo $lic_pre["alert_lic"]; ?>"/></td>
<td align="left" valign="middle">

<select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHide(this.value);">
<option value="Cash" <?php if($lic_pre["pmode"] == "Cash"){?> selected="selected" <?php } ?>>Cash</option>
<option value="Cheque" <?php if($lic_pre["pmode"] == "Cheque"){?> selected="selected" <?php } ?>>Cheque</option>
<option value="Draft" <?php if($lic_pre["pmode"] == "Draft"){?> selected="selected" <?php } ?>>Draft</option>
</select>
</td>
<td align="left" valign="middle"><input name="bankname" type="text" class="textfield121d" id="bankname" value="<?php echo $lic_pre["bankname"]; ?>"/></td>
<td align="center" valign="middle"><input name="ddno" type="text" class="textfield121d" id="ddno" value="<?php echo $lic_pre["ddno"]; ?>" /></td>
<td align="center" valign="middle"><input name="submit" type="submit" class="button" id="submit" value="Submit"></td>
</tr>
</table>
</form>