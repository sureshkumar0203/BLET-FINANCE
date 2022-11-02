<script language="javascript" type="text/javascript">
function editRoadtax(eid){
	//alert(pid);	
	var url="edit_road_tax.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show_tax").html(res);
	});
}
	
$(document).ready(function() {
	$("#frmtax").validationEngine()
});

function showHideRt(mode){
	
	if(mode=="Cheque"){
		document.getElementById('tr_rd').style.display='';
	}
	 //Floor
	if(mode=="Draft"){
		document.getElementById('tr_rd').style.display='';
	}
	//Blinds
	if(mode=="Cash"){
		document.getElementById('tr_rd').style.display='none';
	}
}
</script>
<div id="td_show_tax">
<form action="" method="post" name="frmtax" id="frmtax">
<input name="hid_action" type="hidden" value="3">
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
  <td height="40" align="left" valign="middle">Tax <strong>From</strong> <span class="startext">*</span> : </td>
  <td height="40" align="left" valign="middle" class="text25">
  <input name="tax_from_dt" type="text" class="datepick validate[required] textfield121" id="tax_from_dt" readonly="readonly"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Tax <strong>To</strong> <span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle">
  <input name="tax_to_dt" type="text" class="datepick validate[required] textfield121" id="tax_to_dt" readonly="readonly"/>
  </td>
</tr>
<tr>
<td width="17%" height="40" align="left" valign="middle">Firm Name :</td>
<td width="19%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($firm["firm_name"]);?>
</td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="20%" height="40" align="left" valign="middle">Tax Amount <span class="startext">*</span> : </td>
<td width="40%" height="40" align="left" valign="middle">
<input name="tax_amount" type="text" class="validate[required] textfield121" id="tax_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">RTO Office :</td>
<td height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($rto["rto_name"]);?>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Fine <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="fine" type="text" class="validate[required] textfield121" id="fine" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Owner Name<span class="startext"></span> :</td>
<td height="40" align="left" valign="middle">
<input name="owner_name" type="text" class="validate[required] textfield121" id="owner_name" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Total<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="total" type="text" class="validate[required] textfield121" id="total" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Book Serial No. : </td>
<td height="40" align="left" valign="middle">
<input name="book_sl_no" type="text" class="validate[required] textfield121" id="book_sl_no" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Other Expences : </td>
<td height="40" align="left" valign="middle">
<input name="other_expence" type="text" class="textfield121" id="other_expence" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Issuing Officer :</td>
<td height="40" align="left" valign="middle">
 <input name="issuing_officer" type="text" class="validate[required] textfield121" id="issuing_officer" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle"><input name="alert_tax" type="text" class="validate[required] textfield121" id="alert_tax" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
</tr>


<tr>
  <td height="40" align="left" valign="middle"> Issuing Date : </td>
  <td height="40" align="left" valign="middle"><input name="issuing_date" type="text" class="datepick validate[required] textfield121" id="issuing_date"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <input name="rt_date_of_payment" type="text" class="datepick validate[required] textfield121" id="rt_date_of_payment" readonly="readonly"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHideRt(this.value);">
  <option value="Cash">Cash</option>
  <option value="Cheque">Cheque</option>
  <option value="Draft">Draft</option>
  </select></td>
</tr>
<tr id="tr_rd" style="display:none;">
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
<th width="6%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>

<th width="17%" align="left" valign="middle" class="fetch_headers">Tax from date</th>
<th width="15%" align="left" valign="middle" class="fetch_headers">Tax to date</th>
<th width="16%" align="left" valign="middle" class="fetch_headers">Owner Name</th>
<th width="14%" align="left" valign="middle" class="fetch_headers">Tax Amount</th>
 <th width="10%" align="left" valign="middle" class="fetch_headers">Fine</th>
 <th width="10%" align="left" valign="middle" class="fetch_headers">Total</th>
 <th width="6%" align="left" valign="middle" class="fetch_headers">Alert day</th>
<th colspan="5" align="center" valign="middle" class="fetch_headers">Action</th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$str="vehicle_id='$_REQUEST[id]'";
$num=$db->countRows('roadtax_details',$str);
foreach($db->fetchOrder("roadtax_details",$str,"tax_from_dt","") as $val_tax) { 
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst[id];?>">
<font color="<?php echo $color; ?>"><?php echo $count; ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_tax["tax_from_dt"])); ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?></font></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_tax["owner_name"]); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_tax["tax_amount"],2); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_tax["fine"],2); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_tax["total"],2); ?></td>
<td align="center" class="fetch_contents"><?php echo $val_tax["alert_tax"]; ?></td>
<td width="6%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
 <a href="javascript:void(0);" onClick="editRoadtax(<?php echo $val_tax["id"];?>);">Edit</a>
</td>
</tr>
<?php $count+=1;} ?>
</tbody>
</table>
<br>
