<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';
//Object initialization
$dbf = new User();

?>
<?php 
$res_per=$dbf->fetchSingle("permit_details","id='$_REQUEST[eid]'"); 
/*Get the vehicle no , vehicle type*/
$veh_info=$dbf->fetchSingle("vehicle_registration","id='$res_per[vehicle_id]'");
$veh_typ=$dbf->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");	
$firm = $dbf->strRecordID("firms", "*", "id='$veh_info[firm_name]'");
$rto = $dbf->strRecordID("rto_office" , "*", "id='$veh_info[rto_office]'");
?>

<script>	
$(document).ready(function() {
	$("#frm_permit").validationEngine()
});

</script>	

<form action="" method="post" name="frm_permit" id="frm_permit">
<input name="edit_permit" type="hidden" value="update">
<input name="edit_id" type="hidden" value="<?php echo $res_per["id"];?>">
<input name="vid" type="hidden" value="<?php echo $res_per["vehicle_id"];?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td height="40" colspan="5" align="left" valign="middle">
     <?php if(isset($_REQUEST["msg"])=='added'){ ?>
     <span class="success">Record has been added successfully. </span>
    <?php } ?>
    
    <?php if(isset($_REQUEST["msg"])=='updated'){ ?>
      <span class="success">Record has been updated successfully. </span>
    <?php } ?>
  </td>
  </tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle No<span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_info["display_no"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">RTO Office :</td>
  <td height="40" align="left" valign="middle" class="text25">
  <?php echo strtoupper($rto["rto_name"]);?>
  </td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Permit <strong>From</strong> <span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle">
 <input name="permit_from_dt" type="text" class="datepick validate[required] textfield121" id="permit_from_dt" readonly="readonly" value="<?php echo $res_per["permit_from_dt"]; ?>"/>
  </td>
</tr>
<tr>
<td width="13%" height="40" align="left" valign="middle">Firm Name :</td>
<td width="23%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($firm["firm_name"]);?>
</td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="16%" height="40" align="left" valign="middle">Permit <strong>To</strong> <span class="startext">*</span> :</td>
<td width="44%" height="40" align="left" valign="middle">
<input name="permit_to_dt" type="text" class="datepick validate[required] textfield121" id="permit_to_dt" readonly="readonly" value="<?php echo $res_per["permit_to_dt"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Permit No.<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle" class="text25">
<input name="permit_no" type="text" class="validate[required] textfield121r" id="permit_no" value="<?php echo $res_per["permit_no"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Permit Amount <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="permit_amount" type="text" class="validate[required] textfield121" id="permit_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_per["permit_amount"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Issue Date <span class="startext">*</span>: </td>
<td height="40" align="left" valign="middle">
<input name="issue_date" type="text" class="datepick validate[required] textfield121" id="issue_date" readonly="readonly" value="<?php echo $res_per["issue_date"]; ?>"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="alert_permit" type="text" class="validate[required] textfield121" id="alert_permit" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_per["alert_permit"]; ?>"/>
</td>
</tr>

<tr>
  <td height="40" align="left" valign="middle">Name of the holder <span class="startext">*</span>:</td>
  <td height="40" align="left" valign="middle"><input name="name_of_holder" type="text" class="validate[required] textfield121r" id="name_of_holder" value="<?php echo $res_per["name_of_holder"]; ?>" style="text-transform:uppercase;"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle"><input name="permit_date_of_payment" type="text" class="datepick validate[required] textfield121" id="permit_date_of_payment" readonly="readonly" value="<?php echo $res_per["date_of_payment"]; ?>"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHidePermit(this.value);">
<option value="Cash" <?php if($res_per["mode_of_payment"]=="Cash") { echo "Selected"; }  ?>>Cash</option>
<option value="Cheque" <?php if($res_per["mode_of_payment"]=="Cheque") { echo "Selected"; }  ?>>Cheque</option>
<option value="Draft" <?php if($res_per["mode_of_payment"]=="Draft") { echo "Selected"; }  ?>>Draft</option>
</select></td>
</tr>
<tr id="tr_permit" <?php  if($res_per["mode_of_payment"]=="Cheque" || $res_per["mode_of_payment"]=="Draft")  { ?>style="display:'';" <?php } else { ?> style="display:none;" <?php } ?>>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Cheque / Draft No. : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle"><input name="cheque_no" type="text" class="validate[required] textfield121" id="cheque_no" style="text-transform:uppercase;" value="<?php echo $res_per[cheque_no]; ?>"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">

</td>
</tr>
<tr>
<td height="40" colspan="5" align="left" valign="middle">
<input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
<input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_vehicles.php'">
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