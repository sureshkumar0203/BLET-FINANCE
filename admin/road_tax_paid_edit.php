<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Admin Panel';
include 'application_top.php';

//Object initialization
//$db = new User();

if(isset($_SESSION['admin_id'])==""){
	header("location:index.php");
	exit;
}
$res_tax=$db->fetchSingle("roadtax_details","id='$_REQUEST[edit_id]'");
if($_REQUEST['action']=="update")
{
	$owner_name=strtoupper($_POST[owner_name]);
	$book_sl_no=strtoupper($_POST[book_sl_no]);
	
	if($_REQUEST[mode_of_payment]=="Cash"){
		$cheque_no="";
	}else{
		$cheque_no=$_REQUEST[cheque_no];
	}
	
	$string="owner_name='$owner_name',book_sl_no='$book_sl_no',issuing_officer='$_POST[issuing_officer]',tax_amount='$_POST[tax_amount]',fine='$_POST[fine]',total='$_POST[total]',other_expence='$_POST[other_expence]',alert_tax='$_POST[alert_tax]',date_of_payment='$_REQUEST[issuing_date]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$cheque_no'";
	$db->updateTable("roadtax_details",$string,"id='$_REQUEST[edit_id]'");
	
	header("Location:road_tax_dtls.php?vehicle_id=$_REQUEST[vehicle_id]");
	exit;
	
}
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<!--table sorter ***************************************************** -->	
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
           9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
        } 
    })			
.tablesorterPager({container: $("#pager"), size: 25});
});
</script>
<script>	
$(document).ready(function() {
	$("#FrmPaidEdit").validationEngine()
});
</script>	
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle" ><?php include 'header.php'; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="3" align="left" valign="top"></td>
            </tr>
          <tr>
            <td width="226" align="left" valign="top" height="365"><?php include 'left.php';?></td>
            <td width="10">&nbsp;</td>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Edit Vehicles Road Tax(Paid)</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="road_tax_dtls.php?vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>" class="linkButton">Cancel</a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <?php $veh_info=$db->strRecordID('vehicle_registration', "*", "id='$_REQUEST[vehicle_id]'"); ?>
              <tr>
                <td align="left" valign="top" >
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top" style="padding-left:5px;">
					<table width="50%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="13%" class="text1">&nbsp;</td>
					    <td width="70%" align="right" valign="middle"><span class="text1">Vehicle No :</span></td>
						<td width="17%" align="left"><span class="text25"><?php echo $veh_info["display_no"];?></span></td>
					  </tr>
					</table>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="40" align="center" valign="bottom"><table width="20%" border="1" cellpadding="0" cellspacing="0" bordercolor="#00CC00"  style="box-shadow: 5px 3px 55px #063; border-collapse:collapse;">
                          <tr>
                            <td height="25" align="center" valign="middle" bgcolor="#D2FFFF" class="fetch_header">Paid Section</td>
                          </tr>
                        </table></td>
                        </tr>
                      <tr>
                        <td align="center" valign="top">
                        <form action="" name="FrmPaidEdit" id="FrmPaidEdit" method="post" enctype="multipart/form-data">
                        	<input type="hidden" name="action" value="update">
                           	<input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $_REQUEST[vehicle_id];?>"><br>
                           	<table width="60%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
                           	  <tr>
                           	    <td align="right" valign="middle" class="text2">&nbsp;
                           	      <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $_REQUEST["edit_id"];?>"></td>
                           	    <td colspan="4" align="left" valign="middle" class="text25">&nbsp;</td>
                         	    </tr>
                           	  <tr>
                           	    <td height="28" align="right" valign="middle" class="text2">Owner<span class="startext">*</span> :</td>
                           	    <td colspan="4" align="left" valign="middle" class="text25"><span class="fetch_contents" style="padding-left:3px;">
                           	      <input type="text" name="owner_name" id="owner_name" class="validate[required] textfield121r" value="<?php echo $res_tax[owner_name]; ?>" style="text-transform:uppercase;"/>
                           	    </span></td>
                         	    </tr>
                           	  <tr>
                           	    <td height="28" align="right" valign="middle" class="text2">SlNo/Date<span class="startext">*</span> : <span class="startext"></span> :</td>
                           	    <td colspan="4" align="left" valign="middle" class="text25"><span class="fetch_contents" style="padding-left:3px;">
                           	      <input name="alert_tax" type="text" class="validate[required] textfield121d" id="alert_tax" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax[alert_tax]; ?>"/>
                           	    </span><span class="fetch_contents" style="padding-left:3px;">
                           	    <input name="issuing_date" type="text" class="datepick validate[required] textfield121" id="issuing_date" value="<?php echo $res_tax[issuing_date]; ?>"/>
                           	    </span></td>
                         	    </tr>
                           	  <tr>
                           	    <td width="20%" height="28" align="right" valign="middle" class="text2">Office<span class="startext">*</span> :</td>
                           	    <td colspan="4" align="left" valign="middle" class="text25"><span class="fetch_contents" style="padding-left:3px;">
                           	      <input name="issuing_officer" type="text" class="validate[required] textfield121r" id="issuing_officer" value="<?php echo $res_tax[issuing_officer]; ?>" style="text-transform:uppercase;"/>
                           	      </span></td>
                         	    </tr>
                           	  <tr>
                           	    <td height="28" align="right" valign="middle" class="text2">Tax Amount<span class="startext">*</span> : </td>
                           	    <td width="30%" align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                           	      <input name="tax_amount" type="text" class="validate[required] textfield121" id="tax_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax[tax_amount]; ?>"/>
                           	      </span></td>
                           	    <td width="1%" align="left" valign="middle">&nbsp;</td>
                           	    <td width="20%" align="right" valign="middle" class="text2">&nbsp;</td>
                           	    <td width="29%" align="left" valign="middle">&nbsp;</td>
                         	    </tr>
                           	  <tr>
                           	    <td height="28" align="right" valign="middle" class="text2">Fine Amount<span class="startext">*</span> :</td>
                           	    <td align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                           	      <input name="fine" type="text" class="validate[required] textfield121" id="fine" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax[fine]; ?>"/>
                           	    </span></td>
                           	    <td align="left" valign="middle">&nbsp;</td>
                           	    <td align="right" valign="middle" class="text2">&nbsp;</td>
                           	    <td align="left" valign="middle">&nbsp;</td>
                         	    </tr>
                           	  <tr>
                           	    <td height="28" align="right" valign="middle" class="text2"> Other Expenses<span class="startext">*</span> : </td>
                           	    <td align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                           	      <input name="other_expence" type="text" class="textfield121" id="other_expence" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax[other_expence]; ?>"/>
                           	    </span></td>
                           	    <td align="left" valign="middle">&nbsp;</td>
                           	    <td align="right" valign="middle" class="text2">&nbsp;</td>
                           	    <td align="left" valign="middle">&nbsp;</td>
                         	    </tr>
                           	  <tr>
                           	    <td height="28" align="right" valign="middle" class="text2">Total Amount<span class="startext">*</span>:</td>
                           	    <td align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                           	      <input name="total" type="text" class="validate[required] textfield121" id="total" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_tax[total]; ?>"/>
                           	    </span></td>
                           	    <td align="left" valign="middle">&nbsp;</td>
                           	    <td align="right" valign="middle" class="text2">&nbsp;</td>
                           	    <td align="left" valign="middle">&nbsp;</td>
                         	    </tr>
                           	  <tr>
                           	    <td height="28" align="right" valign="middle" class="text2">Payment Mode<span class="startext">*</span> :</td>
                           	    <td align="left" valign="middle">&nbsp;<select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHideRt(this.value);">
                           	      <option value="Cash" <?php if($res_tax[mode_of_payment]=="Cash") { echo "Selected"; }  ?>>Cash</option>
                           	      <option value="Cheque" <?php if($res_tax[mode_of_payment]=="Cheque") { echo "Selected"; }  ?>>Cheque</option>
                           	      <option value="Draft" <?php if($res_tax[mode_of_payment]=="Draft") { echo "Selected"; }  ?>>Draft</option>
                         	      </select></td>
                           	    <td align="left" valign="middle">&nbsp;</td>
                           	    <td align="right" valign="middle" class="text2">Chq/DD No :</td>
                           	    <td align="left" valign="middle"><input name="cheque_no" type="text" class="textfield121" id="cheque_no" style="text-transform:uppercase;"/></td>
                         	    </tr>
                           	  <tr>
                           	    <td height="40" colspan="5" align="center" valign="middle"><input name="submit" type="submit" class="button" id="submit" value="Submit">
                           	      &nbsp;</td>
                         	    </tr>
                         	  </table>
                        </form>
                        </td>
                        </tr>
                    </table>
                    
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="10">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="12">&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                  </td>
              </tr>
              
            </table></td>
            </tr>
        </table></td>
        <td width="10">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><?php include 'footer.php';?></td>
  </tr>
</table>
</body>
</html>
