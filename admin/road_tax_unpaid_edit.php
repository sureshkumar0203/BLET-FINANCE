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
$res_pending=$db->fetchSingle("roadtax_pending","id='$_REQUEST[edit_id]'");

if($_REQUEST["action"] == "update"){
	
	$vehicle_id=$_REQUEST[vehicle_id];
	$string="vehicle_id='$vehicle_id',tax_from_dt ='$_POST[tax_from_dt]', tax_to_dt ='$_POST[tax_to_dt]',tax_amount ='$_POST[tax_amount]',alert_tax='$_POST[alert_tax]'";
	
	$db->updateTable("roadtax_pending",$string,"id='$_REQUEST[edit_id]'");

	header("Location:road_tax_dtls.php?vehicle_id=$_REQUEST[vehicle_id]");
	exit;
}
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
                          <td width="50%" align="left" valign="middle"><h2> Edit Vehicles Road Tax(Pending)</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="road_tax_dtls.php?vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>" class="linkButton">Cancel</a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <?php 
				$veh_info=$db->strRecordID('vehicle_registration', "*", "id='$_REQUEST[vehicle_id]'");
				$rto = $db->strRecordID("rto_office" , "*", "id='$veh_info[rto_office]'");
				$veh_typ=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");	
				$firm=$db->fetchSingle("firms","id='$veh_info[firm_name]'");
				?>
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
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="5%" class="text1">&nbsp;</td>
					    <td width="8%" height="20" align="right" valign="middle"><span class="text1">Vehicle No :</span></td>
					    <td width="16%" align="left" valign="middle" class="text25">&nbsp;<?php echo $veh_info["display_no"];?></td>
					    <td width="11%" align="right" valign="middle"><span class="fetch_header">Vehicle Type :</span></td>
					    <td width="11%" align="left" class="text2">&nbsp;<?php echo strtoupper($veh_typ[vtype]);?></td>
					    <td width="11%" align="right" valign="middle"><span class="fetch_header">Firm Name :</span></td>
					    <td width="11%" align="left" class="text2">&nbsp;<?php echo strtoupper($firm[firm_name]);?></td>
					    <td width="11%" align="right" valign="middle"><span class="fetch_header">RTO Office :</span></td>
					    <td width="16%" align="left" class="text2">&nbsp;<?php echo strtoupper($rto["rto_name"]);?></td>
					    </tr>
					  <tr>
					    <td class="text1">&nbsp;</td>
					    <td height="20" align="right" valign="middle">&nbsp;</td>
					    <td align="left" valign="middle" class="text25">&nbsp;</td>
					    <td align="right" valign="middle">&nbsp;</td>
					    <td align="left">&nbsp;</td>
					    <td align="left">&nbsp;</td>
					    <td align="left">&nbsp;</td>
					    <td align="left">&nbsp;</td>
					    <td align="left">&nbsp;</td>
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
                        <td align="left" valign="bottom"></td>
                        <td align="left" valign="bottom"></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" valign="top"><table width="20%" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="box-shadow: 5px 3px 55px #FC0; border-collapse:collapse;">
                          <tr>
                            <td height="25" align="center" valign="middle" bgcolor="#FFE6DF" class="fetch_header">Pending Section</td>
                          </tr>
                        </table>
                          <br>
                          <form name="frm" id="frm" method="post" action="road_tax_unpaid_edit.php?action=update">
                          <table width="60%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
                            <tr>
                              <td width="20%" align="right" valign="middle" class="text2">
                              <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $_REQUEST["vehicle_id"];?>">
                              <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $_REQUEST["edit_id"];?>">
                              </td>
                              <td colspan="4" align="left" valign="middle" class="text25">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="28" align="right" valign="middle" class="text2">From Date<span class="startext">*</span> : </td>
                              <td width="30%" align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                                <input name="tax_from_dt" type="text" class="datepick validate[required] textfield121" id="tax_from_dt" readonly="readonly" value="<?php echo $res_pending[tax_from_dt]; ?>"/>
                              </span></td>
                              <td width="1%" align="left" valign="middle">&nbsp;</td>
                              <td width="20%" align="right" valign="middle" class="text2">To Date<span class="startext">*</span>:</td>
                              <td width="29%" align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                                <input name="tax_to_dt" type="text" class="datepick validate[required] textfield121" id="tax_to_dt" readonly="readonly" value="<?php echo $res_pending[tax_to_dt]; ?>"/>
                              </span></td>
                            </tr>
                            <tr>
                            <td height="28" align="right" valign="middle" class="text2">Tax Amount<span class="startext">*</span>:</td>
                            <td align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                              <input name="tax_amount" type="text" class="validate[required] textfield121" id="tax_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_pending[tax_amount]; ?>"/>
                            </span></td>
                            <td align="left" valign="middle">&nbsp;</td>
                            <td align="right" valign="middle" class="text2">&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            
                            
                            <tr>
                              <td height="28" align="right" valign="middle" class="text2"> Alert Tax<span class="startext">*</span>: </td>
                              <td align="left" valign="middle"><span class="fetch_contents" style="padding-left:3px;">
                                <input name="alert_tax" type="text" class="validate[required] textfield121d" id="alert_tax" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_pending[alert_tax]; ?>"/>
                              </span></td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="right" valign="middle" class="text2">&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="40" colspan="5" align="center" valign="middle">
                                <input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;</td>
                            </tr>
                            </table>
                          </form>
                          
                          <br></td>
                        </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
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
