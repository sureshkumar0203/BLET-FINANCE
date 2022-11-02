<script language="javascript" type="text/javascript">
function editFitness(eid){
	//alert(pid);	
	var url="edit_fitness.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show_fitness").html(res);
	});
}
</script>

<script>	
$(document).ready(function() {
	$("#frmFitness").validationEngine()
});


function showHideFitness(mode)
{
	if(mode=="Cheque")
	{
		document.getElementById('tr_fitness').style.display='';
	}
	if(mode=="Draft") //Floor
	{
		document.getElementById('tr_fitness').style.display='';
	}
	
	if(mode=="Cash") //Blinds
	{
		document.getElementById('tr_fitness').style.display='none';
	}
}

</script>	

<div id="td_show_fitness">
<form action="" method="post" name="frmFitness" id="frmFitness">
<input name="hid_action" type="hidden" value="4">
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
  <td height="40" align="left" valign="middle">Fitness <strong>From</strong> <span class="startext">*</span> : </td>
  <td height="40" align="left" valign="middle" class="text25">
  <input name="fitness_from_dt" type="text" class="datepick validate[required] textfield121" id="fitness_from_dt" readonly="readonly"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Fitness <strong>To</strong> <span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle">
  <input name="fitness_to_dt" type="text" class="datepick validate[required] textfield121" id="fitness_to_dt" readonly="readonly"/>
  </td>
</tr>
<tr>
<td width="18%" height="40" align="left" valign="middle">Firm Name :</td>
<td width="18%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($firm["firm_name"]);?>
</td>
<td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="19%" height="40" align="left" valign="middle">RTO Office <span class="startext">*</span> :</td>
<td width="41%" height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($rto["rto_name"]);?></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Certificate No.<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle" class="text25">
<input name="certificate_no" type="text" class="validate[required] textfield121" id="certificate_no" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Fitness Amount <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="fitness_amount" type="text" class="validate[required] textfield121" id="fitness_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Certificate Date <span class="startext">*</span>:</td>
<td height="40" align="left" valign="middle">
<input name="certificate_date" type="text" class="datepick validate[required] textfield121" id="certificate_date" readonly="readonly"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Other Expences : </td>
<td height="40" align="left" valign="middle">
<input name="other_expence" type="text" class="textfield121" id="other_expence" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/>
</td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Issuing Officer <span class="startext">*</span>: </td>
  <td height="40" align="left" valign="middle"><input name="issuing_officer" type="text" class="validate[required] textfield121" id="issuing_officer" style="text-transform:uppercase;"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle"><input name="fitness_date_of_payment" type="text" class="datepick validate[required] textfield121" id="fitness_date_of_payment" readonly="readonly"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle"><input name="alert_fitness" type="text" class="validate[required] textfield121" id="alert_fitness" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHideFitness(this.value);">
  <option value="Cash">Cash</option>
  <option value="Cheque">Cheque</option>
  <option value="Draft">Draft</option>
  </select>
  </td>
</tr>
<tr id="tr_fitness" style="display:none;">
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Cheque / Draft No. : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle"><input name="cheque_no" type="text" class="validate[required] textfield121" id="cheque_no" style="text-transform:uppercase;"/></td>
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

<th width="17%" align="left" valign="middle" class="fetch_headers">Certificate No.</th>
<th width="15%" align="left" valign="middle" class="fetch_headers">Certificate Date</th>
<th width="16%" align="left" valign="middle" class="fetch_headers">Issuing Officer</th>
<th width="14%" align="left" valign="middle" class="fetch_headers">Fitness from</th>
 <th width="10%" align="left" valign="middle" class="fetch_headers">Fitness to</th>
 <th width="10%" align="left" valign="middle" class="fetch_headers">Amount</th>
 <th width="6%" align="left" valign="middle" class="fetch_headers">Alert day</th>
<th colspan="5" align="center" valign="middle" class="fetch_headers">Action</th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$str="vehicle_id='$_REQUEST[id]'";
$num=$db->countRows('fitness_details',$str);
foreach($db->fetchOrder("fitness_details",$str,"certificate_date","") as $val_fit) { 
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst[id];?>">
<font color="<?php echo $color; ?>"><?php echo $count; ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo strtoupper($val_fit["certificate_no"]); ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_fit["certificate_date"])); ?></font></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_fit["issuing_officer"]); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_fit["fitness_from_dt"])); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_fit["fitness_to_dt"])); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_fit["fitness_amount"],2); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $val_fit["alert_fitness"]; ?></td>
<td width="6%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
 <a href="javascript:void(0);" onClick="editFitness(<?php echo $val_fit["id"];?>);">Edit</a>
</td>
</tr>
<?php $count+=1;} ?>
</tbody>
</table>
<br>
