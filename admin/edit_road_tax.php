<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
include 'application_top.php';
//Object initialization
//$db = new User();

?>
<?php 
$res_tax=$db->fetchSingle("roadtax_details","id='$_REQUEST[eid]'"); 
/*Get the vehicle no , vehicle type*/
$veh_info=$db->fetchSingle("vehicle_registration","id='$res_tax[vehicle_id]'");
$veh_typ=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");	
$rto = $db->strRecordID("rto_office" , "*", "id='$veh_info[rto_office]'");
$firm = $db->strRecordID("firms", "*", "id='$veh_info[firm_name]'");
?>

<script>	
$(document).ready(function() {
	$("#frm_road_tax").validationEngine()
});

</script>	

<form action="" method="post" name="frm_road_tax" id="frm_road_tax">
<input name="edit_tax" type="hidden" value="update">
<input name="edit_id" type="hidden" value="<?php echo $res_tax["id"];?>">
<input name="vid" type="hidden" value="<?php echo $res_tax["vehicle_id"];?>">
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
  <td height="40" align="left" valign="middle">Tax <strong>From</strong> date <span class="startext">*</span> : </td>
  <td height="40" align="left" valign="middle" class="text25">
  <input name="tax_from_dt" type="text" class="datepick validate[required] textfield121" id="tax_from_dt" readonly="readonly" value="<?php echo $res_tax["tax_from_dt"]; ?>"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Tax <strong>To</strong> date<span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle">
  <input name="tax_to_dt" type="text" class="datepick validate[required] textfield121" id="tax_to_dt" readonly="readonly" value="<?php echo $res_tax["tax_to_dt"]; ?>"/></td>
</tr>
<tr>
<td width="13%" height="40" align="left" valign="middle">Firm Name : </td>
<td width="23%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($firm["firm_name"]);?>
</td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="16%" height="40" align="left" valign="middle">Tax Amount <span class="startext">*</span> : </td>
<td width="44%" height="40" align="left" valign="middle">
<input name="tax_amount" type="text" class="validate[required] textfield121" id="tax_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax["tax_amount"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">RTO Office : </td>
<td height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($rto["rto_name"]);?>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Fine <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="fine" type="text" class="validate[required] textfield121" id="fine" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax["fine"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Owner Name<span class="startext"></span> : </td>
<td height="40" align="left" valign="middle">
<input name="owner_name" type="text" class="validate[required] textfield121r" id="owner_name" value="<?php echo $res_tax["owner_name"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Total<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="total" type="text" class="validate[required] textfield121" id="total" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax["total"]; ?>"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Book Serial No. :</td>
<td height="40" align="left" valign="middle">
<input name="book_sl_no" type="text" class="validate[required] textfield121r" id="book_sl_no" value="<?php echo $res_tax["book_sl_no"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Other Expences :</td>
<td height="40" align="left" valign="middle">
<input name="other_expence" type="text" class="textfield121" id="other_expence" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax["other_expence"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">
Issuing Officer :
</td>
<td height="40" align="left" valign="middle">
<input name="issuing_officer" type="text" class="validate[required] textfield121r" id="issuing_officer" value="<?php echo $res_tax["issuing_officer"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="alert_tax" type="text" class="validate[required] textfield121" id="alert_tax" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax["alert_tax"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Issuing Date : </td>
<td height="40" align="left" valign="middle">
<input name="issuing_date" type="text" class="datepick validate[required] textfield121" id="issuing_date" value="<?php echo $res_tax["issuing_date"]; ?>"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
<td height="40" align="left" valign="middle">
<input name="rt_date_of_payment" type="text" class="datepick validate[required] textfield121" id="rt_date_of_payment" readonly="readonly" value="<?php echo $res_tax["date_of_payment"]; ?>"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle"></td>
<td height="40" align="left" valign="middle">
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
<td height="40" align="left" valign="middle">
<select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHideRt(this.value);">
<option value="Cash" <?php if($res_tax["mode_of_payment"]=="Cash") { echo "Selected"; }  ?>>Cash</option>
<option value="Cheque" <?php if($res_tax["mode_of_payment"]=="Cheque") { echo "Selected"; }  ?>>Cheque</option>
<option value="Draft" <?php if($res_tax["mode_of_payment"]=="Draft") { echo "Selected"; }  ?>>Draft</option>
</select>
</td>
</tr>
<tr id="tr_rd" <?php  if($res_tax["mode_of_payment"]=="Cheque" || $res_tax["mode_of_payment"]=="Draft")  { ?>style="display:'';" <?php } else { ?> style="display:none;" <?php } ?>>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Cheque / Draft No. : <span class="startext">*</span></td>
<td height="40" align="left" valign="middle">
<input name="cheque_no" type="text" class="validate[required] textfield121" id="cheque_no" style="text-transform:uppercase;" value="<?php echo $res_tax["cheque_no"]; ?>"/>
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