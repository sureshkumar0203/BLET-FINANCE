<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';

//Object initialization
$dbf = new User();

?>
<?php 
$res_ins=$dbf->fetchSingle("insurance_details","id='$_REQUEST[eid]'"); 
/*Get the vehicle no , vehicle type*/
$veh_info=$dbf->fetchSingle("vehicle_registration","id='$res_ins[vehicle_id]'");
$firm = $dbf->strRecordID("firms", "*", "id='$veh_info[firm_name]'");
$veh_typ=$dbf->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");	

?>
<script>	
$(document).ready(function() {
	$("#frm_edit_insurance").validationEngine()
});

</script>	
<form action="" method="post" name="frm_edit_insurance" id="frm_edit_insurance" enctype="multipart/form-data">
<input name="edit_insurance" type="hidden" value="update">
<input name="edit_id" type="hidden" value="<?php echo $res_ins["id"];?>">
<input name="vid" type="hidden" value="<?php echo $res_ins["vehicle_id"];?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td height="40" colspan="5" align="left" valign="middle">
     <?php if(isset($_REQUEST["msg"]) && $_REQUEST["msg"]=='added'){ ?>
     <span class="success">Record has been added successfully. </span>
    <?php } ?>
    
    <?php if(isset($_REQUEST["msg"]) && $_REQUEST["msg"]=='updated'){ ?>
      <span class="success">Record has been updated successfully. </span>
    <?php } ?>
  </td>
  </tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle No<span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_info["display_no"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Prev. Policy No. <span class="startext">*</span> :  </td>
  <td height="40" align="left" valign="middle" class="text25">
  <input name="pre_policy_no" type="text" class="validate[required] textfield2" id="pre_policy_no" value="<?php echo $res_ins["pre_policy_no"]; ?>" readonly/>
  </td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Policy No. <span class="startext">*</span>:</td>
  <td height="40" align="left" valign="middle">
  <input name="policy_no" type="text" class="validate[required] textfield2" id="policy_no" value="<?php echo $res_ins["policy_no"]; ?>"/>
  </td>
</tr>
<tr>
<td width="13%" height="40" align="left" valign="middle">Firm Name :</td>
<td width="23%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($firm["firm_name"]);?>
</td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="14%" height="40" align="left" valign="middle">Period of insurance <strong>From</strong> <span class="startext">*</span> : </td>
<td width="46%" height="40" align="left" valign="middle">
<input name="insurance_from_dt" type="text" class="datepick validate[required] textfield121" id="insurance_from_dt" value="<?php echo $res_ins["insurance_from_dt"]; ?>" readonly="readonly"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Policy Type<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle" class="text25">
<select name="policy_type" class="validate[required]" id="policy_type" style="border:1px solid #CCC; height:25px; width:160px;">
<option value="">--Select--</option>
<option value="Comprensivesive" <?php if($res_ins["policy_type"]=="Comprensivesive") { echo "Selected"; }?>>Comprensivesive</option>
<option value="Third Party" <?php if($res_ins["policy_type"]=="Third Party") { echo "Selected"; }?>>Third Party</option>
</select>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Period of insurance <strong>To</strong> <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="insurance_to_dt" type="text" class="datepick validate[required] textfield121" id="insurance_to_dt" value="<?php echo $res_ins["insurance_to_dt"]; ?>" readonly="readonly"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Insurance Company Name <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="insurance_company_name" type="text" class="validate[required] textfield2" id="insurance_company_name" value="<?php echo $res_ins["insurance_company_name"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Gross Premium <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="gross_premium" type="text" class="validate[required] textfield121" id="gross_premium" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_ins["gross_premium"]; ?>"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle"> Insured Name<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="insured_name" type="text" class="validate[required] textfield2" id="insured_name" value="<?php echo $res_ins["insured_name"]; ?>"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Service Tax <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="service_tax" type="text" class="validate[required] textfield121" id="service_tax" value="<?php echo $res_ins["service_tax"]; ?>"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Issuing Office Address <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
 <textarea name="issuing_address" id="issuing_address" rows="3" cols="27" style="border:1px solid #c8c8c8;text-transform:uppercase;"><?php echo $res_ins["issuing_address"]; ?></textarea>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Stamp Duty<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="stamp_duty" type="text" class="validate[required] textfield121" id="stamp_duty" value="<?php echo $res_ins["stamp_duty"]; ?>"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Upload insurance Scan Copy :</td>
<td height="40" align="left" valign="middle">
<input type="file" name="file" />
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Total <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="total" type="text" class="validate[required] textfield121" id="total" value="<?php echo $res_ins["total"]; ?>"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle"><input name="alert_insurance" type="text" class="validate[required] textfield121" id="alert_insurance" onKeyPress="return onlyNumbers(event);" value="<?php echo $res_ins["alert_insurance"]; ?>"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
<td height="40" align="left" valign="middle">
<input name="date_of_payment" type="text" class="datepick validate[required] textfield121" id="date_of_payment" readonly="readonly" value="<?php echo $res_ins["date_of_payment"]; ?>"/>
</td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHide(this.value);">
  <option value="Cash" <?php if($res_ins["mode_of_payment"]=="Cash") { echo "Selected"; }  ?>>Cash</option>
  <option value="Cheque" <?php if($res_ins["mode_of_payment"]=="Cheque") { echo "Selected"; }  ?>>Cheque</option>
  <option value="Draft" <?php if($res_ins["mode_of_payment"]=="Draft") { echo "Selected"; }  ?>>Draft</option>
  </select></td>
</tr>
<tr id="tr_id" <?php  if($res_ins["mode_of_payment"]=="Cheque" || $res_ins["mode_of_payment"]=="Draft")  { ?>style="display:'';" <?php } else { ?> style="display:none;" <?php } ?>>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Cheque / Draft No. : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <input name="cheque_no" type="text" class="validate[required] textfield121" id="cheque_no" style="text-transform:uppercase;" value="<?php echo $res_ins["cheque_no"]; ?>"/></td>
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