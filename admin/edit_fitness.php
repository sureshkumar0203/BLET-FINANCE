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
$res_fit=$db->fetchSingle("fitness_details","id='$_REQUEST[eid]'"); 
/*Get the vehicle no , vehicle type*/
$veh_info=$db->fetchSingle("vehicle_registration","id='$res_fit[vehicle_id]'");
$firm = $db->strRecordID("firms", "*", "id='$veh_info[firm_name]'");
$rto = $db->strRecordID("rto_office" , "*", "id='$veh_info[rto_office]'");
$veh_typ=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");
?>
<script>	
$(document).ready(function() {
	$("#frm_fitness").validationEngine()
});
</script>
<form action="" method="post" name="frm_fitness" id="frm_fitness">
<input name="edit_fitness" type="hidden" value="update">
<input name="edit_id" type="hidden" value="<?php echo $res_fit["id"];?>">
<input name="vid" type="hidden" value="<?php echo $res_fit["vehicle_id"];?>">
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
  <td height="40" align="left" valign="middle">Fitness <strong>From</strong> <span class="startext">*</span> : </td>
  <td height="40" align="left" valign="middle" class="text25">
  <input name="fitness_from_dt" type="text" class="datepick validate[required] textfield121" id="fitness_from_dt" value="<?php echo $res_fit["fitness_from_dt"]; ?>" readonly="readonly"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Fitness <strong>To</strong> <span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle">
  <input name="fitness_to_dt" type="text" class="datepick validate[required] textfield121" id="fitness_to_dt" value="<?php echo $res_fit["fitness_to_dt"]; ?>" readonly="readonly"/></td>
</tr>
<tr>
<td width="13%" height="40" align="left" valign="middle">Firm Name :</td>
<td width="23%" height="40" align="left" valign="middle" class="text25"><?php echo ($firm["firm_name"]);?></td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="16%" height="40" align="left" valign="middle">RTO Office <span class="startext">*</span> :</td>
<td width="44%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($rto["rto_name"]);?>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Certificate No.<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle" class="text25">
<input name="certificate_no" type="text" class="validate[required] textfield121r" id="certificate_no" value="<?php echo $res_fit["certificate_no"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Fitness Amount <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="fitness_amount" type="text" class="validate[required] textfield121" id="fitness_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_fit["fitness_amount"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Certificate Date <span class="startext">*</span>:</td>
<td height="40" align="left" valign="middle"><input name="certificate_date" type="text" class="datepick validate[required] textfield121" id="certificate_date" value="<?php echo $res_fit["certificate_date"]; ?>" readonly="readonly"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Other Expences : </td>
<td height="40" align="left" valign="middle">
<input name="other_expence" type="text" class="textfield121" id="other_expence" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_fit["other_expence"]; ?>"/>
</td>
</tr>

<tr>
  <td height="40" align="left" valign="middle">Issuing Officer <span class="startext">*</span>: </td>
  <td height="40" align="left" valign="middle"><input name="issuing_officer" type="text" class="validate[required] textfield121r" id="issuing_officer" value="<?php echo $res_fit["issuing_officer"]; ?>" style="text-transform:uppercase;"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle"><input name="fitness_date_of_payment" type="text" class="datepick validate[required] textfield121" id="fitness_date_of_payment" readonly="readonly" value="<?php echo $res_fit["date_of_payment"]; ?>"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle"><input name="alert_fitness" type="text" class="validate[required] textfield121" id="alert_fitness" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_fit["alert_fitness"]; ?>"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHideFitness(this.value);">
<option value="Cash" <?php if($res_fit["mode_of_payment"]=="Cash") { echo "Selected"; }  ?>>Cash</option>
<option value="Cheque" <?php if($res_fit["mode_of_payment"]=="Cheque") { echo "Selected"; }  ?>>Cheque</option>
<option value="Draft" <?php if($res_fit["mode_of_payment"]=="Draft") { echo "Selected"; }  ?>>Draft</option>
</select></td>
</tr>
<tr id="tr_fitness" <?php  if($res_fit["mode_of_payment"]=="Cheque" || $res_fit["mode_of_payment"]=="Draft")  { ?>style="display:'';" <?php } else { ?> style="display:none;" <?php } ?>>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Cheque / Draft No. : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle"><input name="cheque_no" type="text" class="validate[required] textfield121" id="cheque_no" style="text-transform:uppercase;" value="<?php echo $res_fit["cheque_no"]; ?>"/></td>
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