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

$lic_reg=$db->fetchSingle("lic_registration","id='$_REQUEST[id]'"); 

if(isset($_POST["submit"])<>'')
{
	$policy_no=isset($_REQUEST["policy_no"]);
	 
	$num=$db->countRows('lic_registration',"policy_no='$policy_no' AND id!=$_REQUEST[id]");
	if($num>0)
	{
		header("Location:edit_lic_details.php?id=$_REQUEST[id]&msg=exist");
	}
	else
	{
		//update lic_registration table
		$string="name_policy_holder='$_POST[name_policy_holder]',dob='$_POST[dob]',age='$_REQUEST[age]',policy_no='$_POST[policy_no]',premium_amount='$_POST[premium_amount]',mode='$_POST[mode]', 	date_commencement='$_POST[date_commencement]',date_maturity='$_POST[date_maturity]',sum_assured='$_POST[sum_assured]',nominee='$_POST[nominee]',table_term='$_POST[table_term]',name_agent='$_POST[name_agent]',agent_contact_no='$_REQUEST[agent_contact_no]',policy_branch='$_REQUEST[policy_branch]'";
		$db->updateTable("lic_registration",$string,"id='$_REQUEST[id]'");
		header("Location:edit_lic_details.php?id=$_REQUEST[id]&msg=updated");
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
                          <td width="50%" align="left" valign="middle"><h2>Edit LIC Details</h2></td>
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
                           <span class="error">This policy no. already exist. </span>
                          <?php } ?>
                          </td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="middle" class="text1">Name  : </td>
                          <td height="30" align="left" valign="bottom" class="text1">
                          <input name="name_policy_holder" type="text" class="validate[required] textfield121" id="name_policy_holder" style="text-transform:uppercase;" autocomplete="off"  value="<?php echo $lic_reg["name_policy_holder"]; ?>"/>
                          </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                         </tr>

                        <tr>
                          <td width="20%" align="left" valign="middle" class="text1"> DOB : </td>
                          <td width="77%" height="30" align="left" valign="bottom" class="text1">
                          <input name="dob" type="text" id="dob" class="datepick validate[required] textfield121" value="<?php echo $lic_reg["dob"]; ?>" readonly/>
                          <span class="level_msg">(yyyy-m-d) </span>
                          </td>
                          <td width="3%" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        
                           <tr>
                             <td align="left" valign="middle" class="text1">Age : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="age" type="text" class="validate[required] textfield121" id="age" autocomplete="off" value="<?php echo $lic_reg["age"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Policy No. : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="policy_no" type="text" class="validate[required] textfield121" id="policy_no" style="text-transform:uppercase;" autocomplete="off" value="<?php echo $lic_reg["policy_no"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Premium Amount :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="premium_amount" type="text" class="validate[required] textfield121" id="premium_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $lic_reg["premium_amount"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Mode :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <select name="mode" id="mode" style="border:1px solid #CCC; height:25px;" class="validate[required]">
                            <option value="">--Select--</option>
                            <option value="Monthly" <?php if($lic_reg["mode"]=="Monthly") { echo "Selected"; }?>>Monthly</option>
                            <option value="Quarterly" <?php if($lic_reg["mode"]=="Quarterly") { echo "Selected"; }?>>Quarterly</option>
                            <option value="Haly Yearly" <?php if($lic_reg["mode"]=="Haly Yearly") { echo "Selected"; }?>>Haly Yearly</option>
                             <option value="Yearly" <?php if($lic_reg["mode"]=="Yearly") { echo "Selected"; }?>>Yearly</option>
                            </select>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Date of commencement :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                           <input name="date_commencement" type="text" class="datepick validate[required] textfield121" id="date_commencement" autocomplete="off" value="<?php echo $lic_reg["date_commencement"]; ?>" readonly/> 
                           <span class="level_msg">(yyyy-m-d) </span>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Date of Maturity : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="date_maturity" type="text" class="datepick validate[required] textfield121" id="date_maturity" autocomplete="off" value="<?php echo $lic_reg["date_maturity"]; ?>" readonly/>
                             <span class="level_msg">(yyyy-m-d) </span>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Sum Assured  : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="sum_assured" type="text" class="validate[required] textfield121" id="sum_assured" autocomplete="off" value="<?php echo $lic_reg["sum_assured"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Nominee  : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="nominee" type="text" class="validate[required] textfield121" id="nominee" style="text-transform:uppercase;" value="<?php echo $lic_reg["nominee"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Table &amp; Term  : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="table_term" type="text" class="validate[required] textfield121" id="table_term" value="<?php echo $lic_reg["table_term"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Name of Agenet :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="name_agent" type="text" class="validate[required] textfield121" id="name_agent" style="text-transform:uppercase;" value="<?php echo $lic_reg["name_agent"]; ?>"/></td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                          <td align="left" valign="middle" class="text1">Agent Contact No. : </td>
                          <td height="30" align="left" valign="bottom" class="text1">
                        <input name="agent_contact_no" type="text" class="validate[required] textfield121" id="agent_contact_no" value="<?php echo $lic_reg["agent_contact_no"]; ?>"/>
                          </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                         </tr>
                        
                        <tr>
                         <td align="left" valign="middle" class="text1">Policy Branch   :</td>
                         <td height="30" align="left" valign="bottom" class="text1">
                         <input name="policy_branch" type="text" class="validate[required] textfield121" id="policy_branch" style="text-transform:uppercase;" value="<?php echo $lic_reg["policy_branch"]; ?>"/>
                         </td>
                         <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                       </tr>
                           
                        <tr>
                          <td height="10" colspan="4" align="left" class="headingtext"></td>
                          </tr>
                    
                        
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="6" align="left"><input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;               					    <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_lic.php'"></td>
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
