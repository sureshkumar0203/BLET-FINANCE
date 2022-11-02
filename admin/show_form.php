<?php
ob_start();
session_start();
include 'application_top.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//include_once '../includes/class.Main.php';

//Object initialization
//$db = new User();

//Vehicle Info  
$veh_info=$db->fetchSingle("vehicle_registration","id='$_REQUEST[vid]'");
$veh_typ=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");	
?>

<form action="finance_process.php" method="post" id="frm" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="17%" height="40" align="left" valign="middle">Vehicle No<span class="startext">*</span> :<br>
   <input type="hidden" name="vid" value="<?php echo $_REQUEST[vid]; ?>" id="vid"/></td>
    <td width="19%" height="40" align="left" valign="middle">
    <?php echo $veh_info[vehicle_no];?>
    </td>
    <td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
    <td width="12%" height="40" align="left" valign="middle">Total amount paid to bank <span class="startext">*</span> : </td>
    <td width="48%" height="40" align="left" valign="middle">
    <input name="total_amount_paid_to_bank" type="text" class="validate[required] textfield121" id="total_amount_paid_to_bank" value="<?php echo $veh_info[total_amount_paid_to_bank];?>" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
    </tr>
  <tr>
    <td height="40" align="left" valign="middle">Vehicle Type <span class="startext">*</span> :</td>
    <td height="40" align="left" valign="middle">
    <?php echo $veh_typ[vtype];?>
    </td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">No. of installment <span class="startext">*</span> :</td>
    <td height="40" align="left" valign="middle">
     <?php if($veh_info[no_of_installment]=="") { ?>
    <input name="no_of_installment" type="text" class="validate[required] textfield121" id="no_of_installment" value="<?php echo $veh_info[no_of_installment];?>" onKeyPress="return onlyNumbers(event);"/>
      <?php } else { ?>
    <?php echo $veh_info[no_of_installment]; } ?>
    </td>
    </tr>
  <tr>
    <td height="40" align="left" valign="middle">Installment amount / month <span class="startext">*</span> : </td>
    <td height="40" align="left" valign="middle">
    <input name="installment_per_month" type="text" class="validate[required] textfield121" id="installment_per_month" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $veh_info[installment_per_month];?>"/></td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">Rate of interest <span class="startext">*</span> : </td>
    <td height="40" align="left" valign="middle">
    <input name="rate_of_interest" type="text" class="validate[required] textfield121" id="rate_of_interest" value="<?php echo $veh_info[rate_of_interest];?>" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
    </tr>
  <tr>
    <td height="40" align="left" valign="middle">
    Loan start date<span class="startext">*</span> :<br>
    <span class="level_msg">(ex. Y-M-D) </span>
    </td>
    <td height="40" align="left" valign="middle">
    <?php if($veh_info[no_of_installment]=="") { ?>
    <input name="loan_start_date" type="text" class="datepick validate[required] textfield121" id="loan_start_date" value="<?php echo $veh_info[loan_start_date];?>" readonly/>
    <?php } else { ?>
    <?php echo $veh_info[loan_start_date]; } ?>
    </td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">Finance By <span class="startext">*</span> : </td>
    <td height="40" align="left" valign="middle">
    <input name="finance_by" type="text" class="validate[required] textfield121" id="finance_by" value="<?php echo $veh_info[finance_by];?>" style="text-transform:uppercase;"/></td>
    </tr>
  <tr>
    <td height="40" align="left" valign="middle">
    Loan end date <span class="startext">*</span> :<br>
    <span class="level_msg">(ex. Y-M-D) </span>
    </td>
    <td height="40" align="left" valign="middle">
     <?php if($veh_info[no_of_installment]=="") { ?>
    <input name="loan_end_date" type="text" class="datepick validate[required] textfield121" id="loan_end_date" value="<?php echo $veh_info[loan_end_date];?>" readonly/>
     <?php } else { ?>
    <?php echo $veh_info[loan_end_date]; } ?>
    </td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">Payment Bank<span class="startext">*</span> :</td>
    <td height="40" align="left" valign="middle">
    <input name="payment_bank" type="text" class="validate[required] textfield121" id="payment_bank" value="<?php echo $veh_info[payment_bank];?>" style="text-transform:uppercase;"/></td>
    </tr>
  <tr>
    <td height="40" align="left" valign="middle">Finance amount <span class="startext">*</span> :</td>
    <td height="40" align="left" valign="middle">
    <input name="finance_amount" type="text" class="validate[required] textfield121" id="finance_amount" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $veh_info[installment_per_month];?>"/></td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">Loan A/C No. <span class="startext">*</span> :</td>
    <td height="40" align="left" valign="middle">
    <input name="loan_ac_no" type="text" class="validate[required] textfield121" id="loan_ac_no" value="<?php echo $veh_info[loan_ac_no];?>"/></td>
    </tr>
  <tr>
    <td height="40" align="left" valign="middle">Interest amount <span class="startext">*</span> : </td>
    <td height="40" align="left" valign="middle">
    <input name="interest_amount" type="text" class="validate[required] textfield121" id="interest_amount" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $veh_info[installment_per_month];?>"/></td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">Farm Name <span class="startext">*</span> :</td>
    <td height="40" align="left" valign="middle">
    <input name="farm_name" type="text" class="validate[required] textfield121" id="farm_name" value="<?php echo $veh_info[farm_name];?>" style="text-transform:uppercase;"/></td>
    </tr>
  <tr>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">&nbsp;</td>
    <td height="40" align="left" valign="middle">
    Alert Day <span class="startext">*</span> :
    </td>
    <td height="40" align="left" valign="middle">
<input name="alert_finance" type="text" class="validate[required] textfield121" id="alert_finance" value="<?php echo $veh_info[alert_finance];?>" onKeyPress="return onlyNumbers(event);"/>
    </td>
    </tr>
  <tr>
    <td height="40" colspan="5" align="left" valign="middle">
    <input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
     <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_new_vehicles.php'">
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