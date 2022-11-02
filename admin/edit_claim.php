<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
include 'application_top.php';

//Object initialization
//$dbf = new User();

$show = $db->fetchSingle("insurance_cliam", "id='$_REQUEST[eid]'");

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'insert'){
	
	$count = $_POST[stepcount];
	for($i = 1; $i <= $count; $i++){
		$step_id = "step_id".$i;
		$step_id = $_REQUEST[$step_id];
		
		$acc_time = "acc_time".$i;
		$acc_time = $_REQUEST[$acc_time];
		
		$acc_date = "acc_date".$i;
		$acc_date = $_REQUEST[$acc_date];
		
		$inform_by = "inform_by".$i;
		$inform_by = $_REQUEST[$inform_by];
		
		$comment = "remarks1".$i;
		$comment = $db->mysqli->real_escape_string($_REQUEST[$comment]);
		
		if($acc_date != ''){
			
			if($db->countRows("insurance_cliam_dtls", "vehicle_id='$_REQUEST[eid]' And step_id='$step_id'") == 0){
				$string="vehicle_id='$_REQUEST[eid]',step_id='$step_id',acc_date='$acc_date',acc_time='$acc_time',person='$inform_by',remarks1='$comment'";
				$db->insertSet("insurance_cliam_dtls",$string);
			}else{
				$string="acc_date='$acc_date',acc_time='$acc_time',person='$inform_by',remarks1='$comment'";
				$db->updateTable("insurance_cliam_dtls",$string,"vehicle_id='$_REQUEST[eid]' And step_id='$step_id'");
			}
		}
	}
	header("Location:add_all_other_info.php?id=$show[vehicle_id]");
	exit;
}
?>
<script>	
$(document).ready(function() {
	$("#frm_permit").validationEngine()
});
</script>
<form action="edit_claim.php?action=insert&eid=<?php echo $_REQUEST['eid'];?>" method="post" name="frm_permit" id="frm_permit">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="92%" align="left" valign="middle">
    <?php
        $i = 1;
        foreach($db->fetchOrder('insurance_step',"","id") as $step) {
			$veh = $db->fetchSingle("insurance_cliam_dtls","vehicle_id='$_REQUEST[eid]' And step_id='$step[id]'");
        ?>
        <input type="hidden" name="step_id<?php echo $i;?>" id="step_id<?php echo $i;?>" value="<?php echo $step["id"];?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#069;" <?php if($veh["step_id"]>0){ ?> bgcolor="#339900" <?php } ?>>
        <tr>
          <td height="40" align="center" valign="middle"><table width="60%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#FF9933">
            <tr>
              <td align="center" valign="middle" bgcolor="#FFFF66">Step - <?php echo $i;?></td>
            </tr>
          </table></td>
          <td height="40" align="left" valign="middle" class="text25">&nbsp;</td>
          <td align="left" valign="middle" class="text25" style="border-left:solid 1px; border-color:#333;">&nbsp;</td>
          </tr>
        <tr>
          <td width="13%" height="40" align="right" valign="middle"> Date / Time<span class="startext">*</span>:</td>
          <td width="28%" height="40" align="left" valign="middle" class="text25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="48%" height="28" align="left" valign="middle">
                <input name="acc_date<?php echo $i;?>" type="text" class="datepick textfield121" id="acc_date<?php echo $i;?>" readonly="readonly" value="<?php echo $veh["acc_date"];?>"/></td>
              <td width="52%" align="left" valign="middle">&nbsp;</td>
              </tr>
            <tr>
              <td height="28" align="left" valign="middle"><input name="acc_time<?php echo $i;?>" type="text" class="textfield121" id="acc_time<?php echo $i;?>" value="<?php echo $veh["acc_time"]; ?>"/></td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
          </table></td>
          <td width="59%" rowspan="2" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000; border-left:solid 1px; border-color:#333; padding-left:3px;"><?php echo $step["name"];?></td>
          </tr>
        <tr>
          <td height="40" align="right" valign="middle">Person Concern <span class="startext">*</span>: </td>
          <td height="40" align="left" valign="middle">
            <input name="inform_by<?php echo $i;?>" type="text" class="textfield121r" id="inform_by<?php echo $i;?>" value="<?php echo $veh["person"]; ?>" style="text-transform:uppercase;"/></td>
          </tr>
        <tr>
        <td height="40" align="right" valign="middle">Remarks :</td>
        <td height="40" align="left" valign="middle">
          <textarea name="remarks1<?php echo $i;?>" id="remarks1<?php echo $i;?>" style=" width:300px; height:50px; border:solid 1px; border-color:#ccc;"><?php echo $veh["remarks1"]; ?></textarea>
        </td>
        <td align="left" valign="middle" style="border-left:solid 1px; border-color:#333;">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" valign="middle">&nbsp;</td>
          <td align="left" valign="middle">&nbsp;</td>
          <td align="left" valign="middle" style="border-left:solid 1px; border-color:#333;">&nbsp;</td>
        </tr>
    </table>
    <br />
    <?php $i++; } ?>
    <input type="hidden" name="stepcount" id="stepcount" value="<?php echo $i-1;?>" />
    </td>
    <td width="8%">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="12%" align="left">&nbsp;</td>
    <td width="88%" align="left" valign="middle">
    <input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
<input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='add_all_other_info.php?id=<?php echo $show["vehicle_id"];?>'">
    </td>
  </tr>
</table>
</form>
