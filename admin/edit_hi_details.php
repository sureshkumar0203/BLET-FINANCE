<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();

$pageTitle='Admin Panel';
include 'application_top.php';

//Object initialization
//$dbf = new User();


if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}

$hi_reg=$db->fetchSingle("mediclaim_registration","id='$_REQUEST[id]'"); 

if(isset($_POST["submit"])<>'')
{
	$idcard_no=$_REQUEST["idcard_no"];
	 
	$num=$db->countRows('mediclaim_registration',"idcard_no='$idcard_no' AND id!=$_REQUEST[id]");
	if($num>0)
	{
		header("Location:edit_hi_details.php?id=$_REQUEST[id]&msg=exist");
	}
	else
	{
		//update mediclaim_registration table
		$string="policy_holder_name='$_POST[policy_holder_name]',relation='$_POST[relation]',dob='$_REQUEST[dob]',age='$_POST[age]',sum_assured='$_POST[sum_assured]',premium='$_POST[premium]',discount='$_POST[discount]',net_premium='$_POST[net_premium]',service_tax='$_POST[service_tax]',hospital_allowance='$_POST[hospital_allowance]',total='$_POST[total]',tax_benefit='$_POST[tax_benefit]',policy_no='$_REQUEST[policy_no]',idcard_no='$_REQUEST[idcard_no]'";
		$db->updateTable("mediclaim_registration",$string,"id='$_REQUEST[id]'");
		header("Location:edit_hi_details.php?id=$_REQUEST[id]&msg=updated");
	}
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Edit Health Insurance Detail</h2></td>
                          <td width="50%" align="right" valign="middle"></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" height="320">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="righttableborder2">
                  <tr>
                    <td>
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                      <table width="90%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:10px;">
                   
                        <tr>
                          <td height="30" colspan="4" align="left" valign="middle">
                           <?php if(isset($_REQUEST["msg"])=='updated'){ ?>
                          <span class="success">Record has been updated successfully</span>. 
                          <?php } ?>
                          <?php if(isset($_REQUEST["msg"])=='exist'){ ?>
                           <span class="error">This ID Card No. already exist. </span>
                          <?php } ?>
                          </td>
                        </tr>
                        
                         <tr>
                             <td align="left" valign="middle" class="text1">Policy No. : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="policy_no" type="text" class="validate[required] textfield3" id="policy_no" style="text-transform:uppercase;" autocomplete="off" value="<?php echo $hi_reg["policy_no"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">ID Card No. : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="idcard_no" type="text" class="validate[required] textfield121" id="idcard_no" style="text-transform:uppercase;" autocomplete="off" value="<?php echo $hi_reg["idcard_no"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           
                           
                        <tr>
                          <td align="left" valign="middle" class="text1">Name  : </td>
                          <td height="30" align="left" valign="bottom" class="text1">
                          <input name="policy_holder_name" type="text" class="validate[required] textfield121" id="policy_holder_name" style="text-transform:uppercase;" autocomplete="off" value="<?php echo $hi_reg["policy_holder_name"]; ?>"/>
                          </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                         </tr>

                        <tr>
                          <td align="left" valign="middle" class="text1">Relation : </td>
                          <td height="30" align="left" valign="bottom" class="text1">
                          <select name="relation" id="relation" style="border:1px solid #CCC; height:25px;" class="validate[required]">
                            <option value="">--Select--</option>
                            <option value="Head" <?php if($hi_reg["relation"]=="Head") { echo "Selected"; } ?>>Head</option>
                            <option value="Spouse" <?php if($hi_reg["relation"]=="Spouse") { echo "Selected"; } ?>>Spouse</option>
                            <option value="Daughter" <?php if($hi_reg["relation"]=="Daughter") { echo "Selected"; } ?>>Daughter</option>
                            <option value="Son" <?php if($hi_reg["relation"]=="Son") { echo "Selected"; } ?>>Son</option>
                            <option value="Father" <?php if($hi_reg["relation"]=="Father") { echo "Selected"; } ?>>Father</option>
                          </select>
                          </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="15%" align="left" valign="middle" class="text1"> DOB : </td>
                          <td width="82%" height="30" align="left" valign="bottom" class="text1">
                          <input name="dob" type="text" id="dob" class="datepick validate[required] textfield121" value="<?php echo $hi_reg["dob"]; ?>" readonly/>
                          <span class="level_msg">(yyyy-m-d) </span>
                          </td>
                          <td width="3%" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        
                           <tr>
                             <td align="left" valign="middle" class="text1">Age : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="age" type="text" class="validate[required] textfield121" id="age" autocomplete="off" value="<?php echo $hi_reg["age"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Sum Assured : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="sum_assured" type="text" class="validate[required] textfield121" id="sum_assured" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["sum_assured"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Premium : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="premium" type="text" class="validate[required] textfield121" id="premium" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["premium"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Discount : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                              <input name="discount" type="text" class="validate[required] textfield121" id="discount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["discount"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Net Premium : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="net_premium" type="text" class="validate[required] textfield121" id="net_premium" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["net_premium"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Service Tax : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="service_tax" type="text" class="validate[required] textfield121" id="service_tax" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["service_tax"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Hospital Allowance : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="hospital_allowance" type="text" class="validate[required] textfield121" id="hospital_allowance" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["hospital_allowance"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Total : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                              <input name="total" type="text" class="validate[required] textfield121" id="total" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["total"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Tax Benefit :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="tax_benefit" type="text" class="validate[required] textfield121" id="tax_benefit" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $hi_reg["tax_benefit"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>

                           
                        <tr>
                          <td height="10" colspan="4" align="left" class="headingtext"></td>
                          </tr>
                    
                        
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="6" align="left"><input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;               					    <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_mediclaim.php'"></td>
                          </tr>
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                          <td colspan="5" align="left">&nbsp;</td>
                        </tr>
                      </table>
                    </form></td>
                  </tr>
                </table>
				</td>
              </tr>
              <tr>
                <td align="left" valign="top"></td>
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
