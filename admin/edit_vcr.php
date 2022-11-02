<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
include 'application_top.php';
//Object initialization
//$dbf = new User();

$vcr_det = $db->fetchSingle("vcr_details", "id='$_REQUEST[eid]'");

if(isset($_REQUEST['action']) == 'update'){
  $vcr_no=$_REQUEST["vcr_no"];
  $vcr_date=$_REQUEST["vcr_date"];
  $rto_office=$_REQUEST["rto_office"];
  $detail_cause = $db->mysqli->real_escape_string($_REQUEST["detail_cause"]);
  $vcr_close_date=$_REQUEST["vcr_close_date"];
  $vcr_amount=$_REQUEST["vcr_amount"];
  $vcr_ltr_no=$_REQUEST["vcr_ltr_no"];
  $other_expense=$_REQUEST["other_expense"];
	
	$string="vehicle_id='$_REQUEST[vehicle_id]',vcr_no='$vcr_no',vcr_date='$vcr_date',rto_office='$rto_office',detail_cause='$detail_cause',vcr_close_date='$vcr_close_date',vcr_amount='$vcr_amount',vcr_ltr_no='$vcr_ltr_no',other_expense='$other_expense'";
	
  $db->updateTable("vcr_details",$string,"id='$_REQUEST[eid]'");
  header("Location:add_all_other_info.php?id=$_REQUEST[eid]");
  exit;
}
?>

<script>	
$(document).ready(function() {
	$("#frm_permit").validationEngine()
});
</script>
<form action="edit_vcr.php?action=update&eid=<?php echo $_REQUEST['eid'];?>" method="post" name="frm_vcr" id="frm_vcr">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td height="40" align="left" valign="middle">VCR No. : *
   <input name="vehicle_id" id="vehicle_id" type="hidden" value="<?php echo $vcr_det["vehicle_id"]; ?>"/>
  </td>
  <td height="40" align="left" valign="middle">
  <input name="vcr_no" id="vcr_no" type="text" class="validate[required] textfield121r" style="text-transform:uppercase;" value="<?php echo $vcr_det["vcr_no"]; ?>"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Date : <span class="startext">*</span> </td>
<td height="40" align="left" valign="middle">
<input name="vcr_date" type="text" class="datepick validate[required] textfield121" id="vcr_date" autocomplete="off" readonly value="<?php echo $vcr_det["vcr_date"]; ?>"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
</tr>

<tr>
  <td height="40" align="left" valign="middle">RTO Office : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="rto_office" class="validate[required]" id="rto_office" style="border:1px solid #CCC; height:25px; width:150px;">
    <option value="">--Select--</option>
    <?php foreach($db->fetch('rto_office',"","") as $rto) { ?>
    <option value="<?php echo $rto["id"]; ?>" <?php if($rto["id"] == $vcr_det["rto_office"]){?> selected="" <?php } ?>><?php echo $rto["rto_name"]; ?></option>
    <?php } ?>
    </select>
  </td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle"></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Detail Cause :<span class="startext">*</span></td>
<td height="40" align="left" valign="middle">
<textarea name="detail_cause" class="validate[required]" id="detail_cause" style=" width:305px; height:50px; border:solid 1px; border-color:#ccc;"><?php echo $vcr_det["detail_cause"]; ?></textarea>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">
</td>
</tr>

<tr>
<td height="40" align="left" valign="middle">VCR Close Date  <span class="startext">*</span>: </td>
<td height="40" align="left" valign="middle">
<input name="vcr_close_date" type="text" class="datepick validate[required] textfield121" id="vcr_close_date" autocomplete="off" readonly value="<?php if($vcr_det["vcr_close_date"]!="0000-00-00") { echo  $vcr_det["vcr_close_date"]; } ?>"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
</tr>


<tr>
<td height="40" align="left" valign="middle">Amount  <span class="startext">*</span>: </td>
<td height="40" align="left" valign="middle">
<input name="vcr_amount" type="text" class="validate[required] textfield121" id="vcr_amount" autocomplete="off" value="<?php  if($vcr_det["vcr_amount"]!=0) { echo $vcr_det["vcr_amount"]; } ?>"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
</tr>

<tr>
<td height="40" align="left" valign="middle">VCR Letter No.  <span class="startext">*</span>: </td>
<td height="40" align="left" valign="middle">
<input name="vcr_ltr_no" type="text" class="validate[required] textfield121" id="vcr_ltr_no" autocomplete="off" value="<?php echo $vcr_det["vcr_ltr_no"]; ?>"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
</tr>


<tr>
<td height="40" align="left" valign="middle">Other Expense  <span class="startext"></span>: </td>
<td height="40" align="left" valign="middle">
<input name="other_expense" type="text" class="textfield121" id="other_expense" autocomplete="off" value="<?php if($vcr_det["other_expense"]!=0) { echo $vcr_det["other_expense"]; } ?>"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
</tr>


<tr>
<td height="40" colspan="5" align="left" valign="middle">
<input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
<input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='add_all_other_info.php?id=<?php echo $_REQUEST['eid'];?>'">

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
