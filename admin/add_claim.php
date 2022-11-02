<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
include 'application_top.php';

//Object initialization
//$dbf = new User();

//$ic_dtls = $dbf->fetchSingle("insurance_cliam", "vehicle_id='$_REQUEST[eid]'");

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'insert'){
	$comment = $db->mysqli->real_escape_string($_REQUEST["remarks1"]);
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="vehicle_id='$_REQUEST[eid]',place='$_REQUEST[place]',acc_date='$_REQUEST[acc_date]',acc_time='$_REQUEST[acc_time]',acc_by='$_REQUEST[inform_by]',remarks1='$comment',created_date='$cr_date'";
	$db->insertSet("insurance_cliam",$string);
	
	header("Location:add_all_other_info.php?id=$_REQUEST[eid]");
	exit;
}
?>
<script>	
$(document).ready(function() {
	$("#frm_permit").validationEngine()
});
</script>
<form action="add_claim.php?action=insert&eid=<?php echo $_REQUEST['eid'];?>" method="post" name="frm_permit" id="frm_permit">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="13%" height="40" align="left" valign="middle">&nbsp;</td>
  <td width="23%" height="40" align="left" valign="middle" class="text25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left" valign="middle">Accident Date</td>
      <td align="left" valign="middle">Time</td>
    </tr>
    <tr>
      <td width="48%" align="left" valign="middle">
        <input name="acc_date" type="text" class="datepick validate[required] textfield121" id="acc_date" readonly="readonly" value=""/></td>
      <td width="52%" align="left" valign="middle">
        <input name="acc_time" type="text" class="validate[required] textfield121" id="acc_time" value=""/></td>
      </tr>
    </table></td>
  <td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
  <td width="14%" height="40" align="left" valign="middle">&nbsp;</td>
  <td width="46%" height="40" align="left" valign="middle">&nbsp;</td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Place : *</td>
  <td height="40" align="left" valign="middle"><input name="place" type="text" class="validate[required] textfield121r" style="text-transform:uppercase;" value=""/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Driver Name  <span class="startext">*</span>: </td>
<td height="40" align="left" valign="middle">
<input name="inform_by" type="text" class="validate[required] textfield121r" id="inform_by" value="" style="text-transform:uppercase;"/></td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
</tr>

<tr>
<td height="40" align="left" valign="middle">Remarks :</td>
<td height="40" align="left" valign="middle">
<textarea name="remarks1" class="validate[required]" id="remarks1" style=" width:305px; height:50px; border:solid 1px; border-color:#ccc;"></textarea>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">

</td>
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