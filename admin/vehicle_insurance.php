<script language="javascript" type="text/javascript">
function editInsurance(eid){
	//alert(pid);	
	var url="edit_insurance.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show").html(res);
	});
}

function showHide(mode)
{
	if(mode=="Cheque") //Carpet
	{
		document.getElementById('tr_id').style.display='';
	}
	if(mode=="Draft") //Floor
	{
		document.getElementById('tr_id').style.display='';
	}
	
	if(mode=="Cash") //Blinds
	{
		document.getElementById('tr_id').style.display='none';
	}
}
</script>

<?php
/*Edit Insurance Information*/
$policy_chk=$db->countRows('insurance_details',"vehicle_id='$_REQUEST[id]'");
if($policy_chk==0){
	$res_ins=$db->fetchSingle("insurance_details","vehicle_id='$_REQUEST[id]'");
	$policy_no=$res_ins["policy_no"];
	$prv_policy_no=$res_ins["policy_no"];
}else{
	$res_ins=$db->fetchSingle("insurance_details","vehicle_id='$_REQUEST[id]' order by id DESC");
	$policy_no="";
	$prv_policy_no=$res_ins["policy_no"];
}
?>
<script>	
$(document).ready(function() {
	$("#frm_insurance").validationEngine()
});
</script>	

<div id="td_show">
<form action="" method="post" name="frm_insurance" id="frm_insurance" enctype="multipart/form-data">
<input name="hid_action" type="hidden" value="2">
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
  <td height="40" align="left" valign="middle">Vehicle No <span class="startext"></span> :</td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_info["display_no"]);?>  </td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Prev. Policy No. <span class="startext">*</span> :  </td>
  <td height="40" align="left" valign="middle" class="text25">
  <?php if($prv_policy_no!="") { ?>
  <input name="pre_policy_no" type="text" class="validate[required] textfield121" id="pre_policy_no" readonly="readonly" value="<?php echo $prv_policy_no; ?>"/>
  <?php } else { ?>
  <input name="pre_policy_no" type="text" class="validate[required] textfield121" id="pre_policy_no" style="text-transform:uppercase;"/>
  <?php } ?>
  </td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Vehicle Type <span class="startext"></span> : </td>
  <td height="40" align="left" valign="middle" class="text25"><?php echo strtoupper($veh_typ["vtype"]);?></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Policy No. <span class="startext">*</span>:</td>
  <td height="40" align="left" valign="middle">
  <input name="policy_no" type="text" class="validate[required] textfield121" id="policy_no" value="<?php echo $policy_no; ?>" style="text-transform:uppercase;"/>
  </td>
</tr>
<tr>
<td width="20%" height="40" align="left" valign="middle">Firm Name :</td>
<td width="22%" height="40" align="left" valign="middle" class="text25">
<?php echo strtoupper($firm["firm_name"]);?>
</td>
<td width="2%" height="40" align="left" valign="middle">&nbsp;</td>
<td width="23%" height="40" align="left" valign="middle">Period of insurance <strong>From</strong> <span class="startext">*</span> : </td>
<td width="33%" height="40" align="left" valign="middle">
<input name="insurance_from_dt" type="text" class="datepick validate[required] textfield121" id="insurance_from_dt" readonly="readonly"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Policy Type<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle" class="text25">
<select name="policy_type" class="validate[required]" id="policy_type" style="border:1px solid #CCC; height:25px; width:160px;">
<option value="">--Select--</option>
<option value="Comprensivesive" <?php if($res_ins["policy_type"]=="Comprensivesive") { echo "Selected"; }?>>Comprensivesive</option>
<option value="Third Party" <?php if($res_ins["policy_type"]=="Third Party") { echo "Selected"; }?>>Third Party</option>
</select>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Period of insurance <strong>To</strong> <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="insurance_to_dt" type="text" class="datepick validate[required] textfield121" id="insurance_to_dt" readonly="readonly"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Insurance Company Name <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="insurance_company_name" type="text" class="validate[required] textfield121" id="insurance_company_name" value="<?php echo $res_ins["insurance_company_name"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Gross Premium <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="gross_premium" type="text" class="validate[required] textfield121" id="gross_premium" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle"> Insured Name<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="insured_name" type="text" class="validate[required] textfield121" id="insured_name" value="<?php echo $res_ins["insured_name"]; ?>" style="text-transform:uppercase;"/>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Service Tax <span class="startext">*</span> : </td>
<td height="40" align="left" valign="middle">
<input name="service_tax" type="text" class="validate[required] textfield121" id="service_tax"/>
</td>
</tr>
<tr>
<td height="40" align="left" valign="middle"> Issuing Office Address <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
 <textarea name="issuing_address" id="issuing_address" rows="3" cols="17" style="border:1px solid #c8c8c8;text-transform:uppercase;" class="validate[required]"><?php echo $res_ins["issuing_address"]; ?></textarea>
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Stamp Duty<span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="stamp_duty" type="text" class="validate[required] textfield121" id="stamp_duty"/></td>
</tr>
<tr>
<td height="40" align="left" valign="middle">Upload insurance Scan Copy : </td>
<td height="40" align="left" valign="middle">
<input type="file" name="file" />
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle">Total <span class="startext">*</span> :</td>
<td height="40" align="left" valign="middle">
<input name="total" type="text" class="validate[required] textfield121" id="total"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">Alert Day<span class="startext">*</span> :</td>
  <td height="40" align="left" valign="middle"><input name="alert_insurance" type="text" class="validate[required] textfield121" id="alert_insurance" onKeyPress="return onlyNumbers(event);"/></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Date of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <input name="date_of_payment" type="text" class="datepick validate[required] textfield121" id="date_of_payment" readonly="readonly"/></td>
</tr>
<tr>
  <td height="40" align="left" valign="middle"></td>
  <td height="40" align="left" valign="middle"></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Mode of Payment : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHide(this.value);">
  <option value="Cash">Cash</option>
  <option value="Cheque">Cheque</option>
  <option value="Draft">Draft</option>
  </select>
  </td>
</tr>
<tr id="tr_id" style="display:none;">
  <td height="40" align="left" valign="middle"></td>
  <td height="40" align="left" valign="middle"></td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">Cheque / Draft No. : <span class="startext">*</span></td>
  <td height="40" align="left" valign="middle">
  <input name="cheque_no" type="text" class="validate[required] textfield121" id="cheque_no" style="text-transform:uppercase;"/>
  </td>
</tr>
<tr>
<td height="40" align="left" valign="middle"></td>
<td height="40" align="left" valign="middle">
</td>
<td height="40" align="left" valign="middle">&nbsp;</td>
<td height="40" align="left" valign="middle"></td>
<td height="40" align="left" valign="middle">
</td>
</tr>
<tr>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle">&nbsp;</td>
  <td height="40" align="left" valign="middle"></td>
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

<th width="21%" align="left" valign="middle" class="fetch_headers">Insurance Period Detail</th>
<th width="21%" align="left" valign="middle" class="fetch_headers">Policy No. Detail</th>
<th width="12%" align="left" valign="middle" class="fetch_headers">Gross premium</th>
<th width="10%" align="left" valign="middle" class="fetch_headers">Service tax</th>
 <th width="8%" align="left" valign="middle" class="fetch_headers">Stamp duty</th>
 <th width="10%" align="left" valign="middle" class="fetch_headers">Total</th>
 <th width="6%" align="left" valign="middle" class="fetch_headers">Alert day</th>
<th colspan="5" align="center" valign="middle" class="fetch_headers">Action</th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$str="vehicle_id='$_REQUEST[id]'";
$num=$db->countRows('insurance_details',$str);
foreach($db->fetchOrder("insurance_details",$str,"","") as $val_insu) { 
//if($val_inst["next_payment_date"]==$td) {  $color="#FF0000"; } else { $color=""; }
?>
<tr>
<td height="30" align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst[id];?>">
<font color="<?php echo $color; ?>"><?php echo $count; ?></font>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;"><b>
<font color="#009900"><?php echo date("jS M,Y",strtotime($val_insu["insurance_from_dt"])); ?></font> -  
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($val_insu["insurance_to_dt"])); ?></font>
</b>
</td>

<td align="left" class="fetch_contents" style="padding-left:3px;">
<font color="#FF0000"><b>PP : </b><?php echo $val_insu["pre_policy_no"]; ?></font> <br />
<font color="#009900"><b>CP : </b><?php echo $val_insu["policy_no"]; ?></font><br />
<?php if($val_insu["file_name"]!="") { ?>
 <a href="download.php?file=insurance_docs/<?=$val_insu["file_name"];?>" class="fetch_content">Download</a>
<?php } ?>
</td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_insu["gross_premium"],2); ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_insu["service_tax"],2); ?></td>
<td align="center" class="fetch_contents"><?php echo $val_insu["stamp_duty"]; ?></td>
<td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_insu["total"],2); ?></td>
<td align="center" class="fetch_contents"><?php echo $val_insu["alert_insurance"]; ?></td>
<td width="6%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
 <a href="javascript:void(0);" onClick="editInsurance(<?php echo $val_insu["id"];?>);">Edit</a>
</td>
</tr>
<?php $count+=1;} ?>
</tbody>
</table>
<br>
