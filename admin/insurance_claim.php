<script language="javascript" type="text/javascript">
function editClaim(eid){
	//alert(pid);
	var url="edit_claim.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show_claim").html(res);
	});
}
function addClaim(eid){
	var url="add_claim.php";	
	$.post(url,{"eid":eid},function(res){	
		$("#td_show_claim").html(res);
	});
}
</script>

<script>	
$(document).ready(function() {
	$("#frmPermit").validationEngine()
});
</script>	

<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="73%">&nbsp;</td>
    <td width="27%" align="left" style="padding-top:3px; padding-bottom:3px;">
    <table width="80%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#CCCCCC">
      <tr>
        <td width="47%" height="25" align="left" valign="middle">Vehicle No<span class="startext"></span> :</td>
        <td width="53%" height="25" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_info["display_no"]);?></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
        <td height="25" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
      </tr>
      </table></td>
  </tr>
</table>

<div id="td_show_claim">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="84%">&nbsp;</td>
    <td width="16%" align="left" valign="middle"><h2><a href="javascript:void(0);" onClick="addClaim('<?php echo $_REQUEST["id"];?>');" class="linkButton">New</a></h2></td>
  </tr>
</table>
<table height="23" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
<thead>
    <tr>
    <th width="4%" align="center" valign="middle" class="fetch_headers">SL. No.</th>
    <th width="12%" align="left" valign="middle" class="fetch_headers">Accident Date / Time</th>
    <th width="14%" align="left" valign="middle" class="fetch_headers">Driver Name</th>
    <th width="16%" align="left" valign="middle" class="fetch_headers">Place</th>
    <th width="24%" align="left" valign="middle" class="fetch_headers">Remarks</th>
    <th width="9%" align="center" valign="middle" class="fetch_headers">Settlememt Amount</th>
    <th width="11%" align="center" valign="middle" class="fetch_headers">Current Step</th>
    <th colspan="6" align="center" valign="middle" class="fetch_headers">Action</th>
    </tr>
</thead>
<tbody>
<?php
$count=1;
$str="vehicle_id='$_REQUEST[id]'";
$num=$db->countRows('insurance_cliam',$str);
foreach($db->fetchOrder("insurance_cliam",$str,"","") as $val_per) { 
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo $count; ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo date('d.M.Y',strtotime($val_per["acc_date"])); ?>, <?php echo $val_per["acc_time"];?></font>
</td>
<?php
$step_count = $db->countRows("insurance_step", "");
$spt_count = $db->countRows("insurance_cliam_dtls", "vehicle_id='$val_per[id]'");
if($spt_count > 0){
	$sss = "Step - ".$spt_count;
}else{
	$sss = "Process not started";
}
if($spt_count > 0 && $spt_count < $step_count){
	$color = "#FF3399";
}else if($spt_count == 0){
	$color = "#FF0000";
}else if($spt_count == $step_count){
	$color = "#009900";
}
?>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_per["acc_by"]); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_per["place"]); ?></td>
<td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_per["remarks1"]); ?></td>
<td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_per["set_amount"],2); ?></td>
<td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($sss); ?></td>
<td width="5%" align="center" style="background-color:<?php echo $color;?>;">
<?php if($spt_count == $step_count){ ?>
<a href="insu_settle_amt.php?eid=<?php echo $val_per[id];?>&page=insu_settle_amt.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../images/currency.png" width="24" height="24" border="0" /></a>
<?php } ?>
</td>
<td width="5%" align="center" bgcolor="<?=$color;?>" class="fetch_contents"><?php //echo $val_per["id"];?>
 <a href="javascript:void(0);" onClick="editClaim(<?php echo $val_per["id"];?>);">Edit</a>
</td>
</tr>
<?php $count+=1;} ?>
</tbody>
</table>
<?php if($num == 0){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td height="30" colspan="9" align="center" style="padding-left:3px; color:#F00;">
  No accidental history available for this vehicle.</td>
</tr>
</table>
<?php } ?>
</div>
<br>
