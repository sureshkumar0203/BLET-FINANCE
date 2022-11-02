<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
include 'application_top.php';

//Object initialization
//$dbf = new User();

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'insert'){
	
	$vcr_no=$_REQUEST[vcr_no];
	$vcr_date=$_REQUEST[vcr_date];
	$rto_office=$_REQUEST[rto_office];
	$detail_cause = $db->mysqli->real_escape_string($_REQUEST[detail_cause]);
	
	$string="vehicle_id='$_REQUEST[id]',vcr_no='$vcr_no',vcr_date='$vcr_date',rto_office='$rto_office',detail_cause='$detail_cause'";
	$db->insertSet("vcr_details",$string);
	
	header("Location:add_all_other_info.php?id=$_REQUEST[id]");
	exit;
}
?>
<script>	
$(document).ready(function() {
	$("#frm_permit").validationEngine()
});
</script>
<form action="add_vcr.php?action=insert&id=<?php echo $_REQUEST['id'];?>" method="post" name="frm_vcr" id="frm_vcr">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td height="40" align="left" valign="middle">VCR No. : *</td>
  <td height="40" align="left" valign="middle"><input name="vcr_no" id="vcr_no" type="text" class="validate[required] textfield121r" style="text-transform:uppercase;"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Date : <span class="startext">*</span> </td>
<td height="40" align="left" valign="middle">
<input name="vcr_date" type="text" class="datepick validate[required] textfield121" id="vcr_date" autocomplete="off" readonly /></td>
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
    <option value="<?php echo $rto["id"]; ?>"><?php echo $rto["rto_name"]; ?></option>
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
<textarea name="detail_cause" class="validate[required]" id="detail_cause" style=" width:305px; height:50px; border:solid 1px; border-color:#ccc;"></textarea>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">

</td>
</tr>


<tr>
<td height="40" colspan="5" align="left" valign="middle">
<input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
<input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='add_all_other_info.php?id=<?php echo $_REQUEST['id'];?>'">
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