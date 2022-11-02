<script language="javascript" type="text/javascript">
function editVcr(eid){
	//alert(pid);
	var url="edit_vcr.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show_vcr").html(res);
	});
}
function addVcr(id){
	var url="add_vcr.php";	
	$.post(url,{"id":id},function(res){	
		$("#td_show_vcr").html(res);
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
      <tr>
        <td height="25" align="left" valign="middle">Firm Name :</td>
        <td height="25" align="left" valign="middle" class="text25"><?php echo strtoupper($firm["firm_name"]);?></td>
      </tr>
      </table></td>
  </tr>
</table>

<div id="td_show_vcr">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="84%">&nbsp;</td>
    <td width="16%" align="left" valign="middle" style="padding-left:20px;"><h2><a href="javascript:void(0);" onClick="addVcr('<?php echo $_REQUEST["id"];?>');" class="linkButton">New</a></h2></td>
  </tr>
</table>
<table height="23" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
<thead>
    <tr>
    <th width="4%" align="center" valign="middle" class="fetch_headers">SL</th>
    <th width="12%" align="left" valign="middle" class="fetch_headers">VCR No.</th>
    <th width="14%" align="left" valign="middle" class="fetch_headers">VCR Date</th>
    <th width="16%" align="left" valign="middle" class="fetch_headers">RTO Office</th>
    <th width="24%" align="left" valign="middle" class="fetch_headers">Detail Cause</th>
    <th width="9%" align="left" valign="middle" class="fetch_headers">VCR Close Date</th>
    <th width="11%" align="left" valign="middle" class="fetch_headers">Amount</th>
    <th width="11%" align="left" valign="middle" class="fetch_headers">VCR Letter No.</th>
    <th width="11%" align="left" valign="middle" class="fetch_headers">Other Expense </th>
    <th colspan="6" align="center" valign="middle" class="fetch_headers">Action</th>
    </tr>
</thead>
<tbody>
<?php
$count=1;
$num=$db->countRows('vcr_details',$str);
foreach($db->fetchOrder("vcr_details",$str,"","") as $val_vcr) {
	$rto = $db->strRecordID("rto_office" , "*", "id='$val_vcr[rto_office]'");
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo $count; ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_vcr["vcr_no"]);?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_vcr["vcr_date"]));?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
<td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_vcr["detail_cause"]); ?></td>
<td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;">
<?php 
if($val_vcr["vcr_close_date"]!="0000-00-00")
{
	echo date("jS M,Y",strtotime($val_vcr["vcr_close_date"]));
}
?>
</td>
<td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;">
<?php if($val_vcr["vcr_amount"]!=0) { echo "Rs. ".number_format($val_vcr["vcr_amount"],2); } ?>
</td>
<td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;">
<?php echo strtoupper($val_vcr["vcr_ltr_no"]);?>
</td>
<td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;">
<?php if($val_vcr["other_expense"]!=0) { echo "Rs. ".number_format($val_vcr["other_expense"],2); } ?>
</td>
<td width="5%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
  <a href="javascript:void(0);" onClick="editVcr(<?php echo $val_vcr["id"];?>);">Edit</a>
</td>
</tr>
<?php $count+=1;} ?>
</tbody>
</table>
<?php if($num == 0){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td height="30" colspan="9" align="center" style="padding-left:3px; color:#F00;">No VCR history available for this vehicle.</td>
</tr>
</table>
<?php } ?>
</div>
<br>
