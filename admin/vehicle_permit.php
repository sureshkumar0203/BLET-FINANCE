<script language="javascript" type="text/javascript">
function editPermit(eid){
	//alert(pid);	
	var url="edit_permit.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show_permit").html(res);
	});
}
</script>

<script>	
$(document).ready(function() {
	$("#frmPermit").validationEngine()
});

function showHidePermit(mode)
{
	if(mode=="Cheque")
	{
		document.getElementById('tr_permit').style.display='';
	}
	if(mode=="Draft") 
	{
		document.getElementById('tr_permit').style.display='';
	}
	
	if(mode=="Cash") 
	{
		document.getElementById('tr_permit').style.display='none';
	}
}
</script>	

<div id="td_show_permit">
<form action="" method="post" name="frmPermit" id="frmPermit">
<input name="hid_action" type="hidden" value="5">
<input name="vid" type="hidden" value="<?php echo $_REQUEST["id"]; ?>">

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
  <td height="40" align="left" valign="middle">RTO Office : </td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($rto["rto_name"]);?></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Permit <strong>From</strong> <span class="startext">*</span> : </td>
  <td height="40" align="left" valign="middle">
  <input name="permit_from_dt" type="text" class="datepick validate[required] textfield121" id="permit_from_dt" readonly="readonly"/>
  </td>
</tr>
<tr>
<td width="13%" height="40" align="left" valign="middle">Firm Name : </td>
<td width="23%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($firm["firm_name"]);?>
</td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="16%" height="40" align="left" valign="middle">Permit <strong>To</strong> <span class="startext">*</span> :</td>
<td width="44%" height="40" align="left" valign="middle">
<input name="permit_to_dt" type="text" class="datepick validate[required] textfield121" id="permit_to_dt" readonly="readonly"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Permit No.<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle" class="text25">
<input name="permit_no" type="text" class="validate[required] textfield121r" id="permit_no" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Permit Amount <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="permit_amount" type="text" class="validate[required] textfield121" id="permit_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Issue Date <span class="startext">*</span>: </td>
<td height="40" align="left" valign="middle">
<input name="issue_date" type="text" class="datepick validate[required] textfield121" id="issue_date" readonly="readonly"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="alert_permit" type="text" class="validate[required] textfield121" id="alert_permit" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>




<tr>
  <td height="40" align="left" valign="middle">Name of the holder <span class="startext">*</span>:</td>
  <td height="40" align="left" valign="middle">
  <input name="name_of_holder" type="text" class="validate[required] textfield121r" id="name_of_holder" style="text-transform:uppercase;"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle"><input name="permit_date_of_payment" type="text" class="datepick validate[required] textfield121" id="permit_date_of_payment" readonly="readonly"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle"></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHidePermit(this.value);">
  <option value="Cash">Cash</option>
  <option value="Cheque">Cheque</option>
  <option value="Draft">Draft</option>
  </select></td>
</tr>
<tr id="tr_permit" style="display:none;">
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Cheque / Draft No. : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <input name="cheque_no" type="text" class="validate[required] textfield121" id="cheque_no" style="text-transform:uppercase;"/></td>
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
</div>

<table height="61" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
<thead>
<tr>
<th width="6%" height="27" align="center" valign="middle" class="fetch_headers">SL. No.</th>

<th width="17%" align="left" valign="middle" class="fetch_headers">Permit No.</th>
<th width="15%" align="left" valign="middle" class="fetch_headers">Issue Date</th>
<th width="16%" align="left" valign="middle" class="fetch_headers">Name of the holder</th>
<th width="14%" align="left" valign="middle" class="fetch_headers">Permit from</th>
 <th width="10%" align="left" valign="middle" class="fetch_headers">Permit to</th>
 <th width="10%" align="left" valign="middle" class="fetch_headers">Amount</th>
 <th width="6%" align="left" valign="middle" class="fetch_headers">Alert day</th>
<th colspan="5" align="center" valign="middle" class="fetch_headers">Action</th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$str="vehicle_id='$_REQUEST[id]'";
$num=$db->countRows('permit_details',$str);
foreach($db->fetchOrder("permit_details",$str,"","") as $val_per) { 
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst["id"];?>">
<font color="<?php echo $color; ?>"><?php echo $count; ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo strtoupper($val_per["permit_no"]); ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_per["issue_date"])); ?></font></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_per["name_of_holder"]); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_per["permit_from_dt"])); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_per["permit_to_dt"])); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_per["permit_amount"],2); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $val_per["alert_permit"]; ?></td>
<td width="6%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
 <a href="javascript:void(0);" onClick="editPermit(<?php echo $val_per["id"];?>);">Edit</a>
</td>
</tr>
<?php $count+=1;} ?>
</tbody>
</table>
<br>
