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

if(isset($_POST['submit'])<>'')
{
	$num=$db->countRows('driving_licence',"dl_no='$_REQUEST[dl_no]'");
	if($num>0)
	{
		header("Location:add_dl.php?msg=exist");
	}
	else
	{
		//insert to driving_licence table
		 $vehicle_class=join(",",$_REQUEST[vehicle_class]);
		 $string="first_name='$_POST[first_name]',middle_name='$_POST[middle_name]',last_name='$_POST[last_name]',fathers_name='$_POST[fathers_name]',address='$_POST[address]',contact_no='$_POST[contact_no]',dob='$_POST[dob]',dl_no='$_POST[dl_no]',place_of_issue='$_POST[place_of_issue]',date_of_issue='$_POST[date_of_issue]',valid_till='$_REQUEST[valid_till]',vehicle_class='$vehicle_class',referred_by='$_REQUEST[referred_by]',referer_mob_no='$_REQUEST[referer_mob_no]',dl_verify='$_REQUEST[dl_verify]',verified_date='$_REQUEST[verified_date]',alert_licence='$_REQUEST[alert_licence]'";
		$db->insertSet("driving_licence",$string);
		header("Location:add_dl.php?msg=added");
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
                          <td width="50%" align="left" valign="middle"><h2>Add Driving Licence Detail</h2></td>
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
                           <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='added'){ ?>
                          <span class="success">Record has been added  successfully</span>. 
                          <?php } ?>
                          <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='exist'){ ?>
                           <span class="error">This DL No. already exist. </span>
                          <?php } ?>
                          </td>
                        </tr>
                        
                        <tr>
                          <td height="30" colspan="2" align="left" valign="middle" class="text1">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr class="text1">
                              <td width="20%">First Name :</td>
                              <td width="15%" align="left"><input name="first_name" type="text" class="validate[required] textfield121d" id="first_name" style="text-transform:uppercase;" autocomplete="off"/>
                              </td>
                              <td width="14%" align="right" valign="middle">Middle Name : </td>
                              <td width="17%" align="left" valign="middle">
                              <input name="middle_name" type="text" class="textfield121d" id="middle_name" autocomplete="off" style="text-transform:uppercase;"/></td>
                              <td width="11%">Last Name :</td>
                              <td width="23%">
                              <input name="last_name" type="text" class="validate[required] textfield121d" id="last_name" autocomplete="off" style="text-transform:uppercase;"/></td>
                            </tr>
                          </table>
                            </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                         </tr>

                        <tr>
                          <td align="left" valign="middle" class="text1">Father's Name :</td>
                          <td height="30" align="left" valign="bottom" class="text1">
                          <input name="fathers_name" type="text" class="validate[required] textfield2" id="fathers_name" style="width:274px;text-transform:uppercase;" autocomplete="off"/>
                          </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="20%" align="left" valign="top" class="text1" style="padding-top:5px;">Address : </td>
                          <td width="77%" height="30" align="left" valign="bottom" class="text1" style="padding-top:5px;">
                   <textarea rows="4" cols="32" style="border:1px solid #CCC;text-transform:uppercase;" name="address" id="address" class="validate[required]"></textarea>
                          </td>
                          <td width="3%" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        
                           <tr>
                             <td align="left" valign="middle" class="text1">Conatct No.</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="contact_no" type="text" class="validate[required] textfield121" id="contact_no" autocomplete="off" />
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">D.O.B :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="dob" type="text" class="datepick validate[required] textfield121" id="dob" autocomplete="off" readonly/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">DL No.</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="dl_no" type="text" class="validate[required] textfield121" id="dl_no" autocomplete="off" style="text-transform:uppercase;"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Place of issue : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="place_of_issue" type="text" class="validate[required] textfield121" id="place_of_issue" style="text-transform:uppercase;"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Date of issue :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                           <input name="date_of_issue" type="text" class="datepick validate[required] textfield121" id="date_of_issue" readonly/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Valid Till :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                          <input name="valid_till" type="text" class="datepick validate[required] textfield121" id="valid_till" autocomplete="off"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Vehicle Class : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input type="checkbox" name="vehicle_class[]" id="vehicle_class" value="1">LMV
                             &nbsp; &nbsp; &nbsp; &nbsp;
                             <input type="checkbox" name="vehicle_class[]" id="vehicle_class" value="2">PSV BADGE
                             &nbsp; &nbsp; &nbsp; &nbsp;
                              <input type="checkbox" name="vehicle_class[]" id="vehicle_class" value="3">HGV
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Referred by : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                  <input name="referred_by" type="text" class="validate[required] textfield2" id="referred_by" style="width:274px;text-transform:uppercase;" autocomplete="off"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Referer Mobile No:</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="referer_mob_no" type="text" class="validate[required] textfield121" id="referer_mob_no" autocomplete="off" />
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">DL Verify :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <select name="dl_verify" class="" id="dl_verify" style="border:1px solid #CCC; height:25px; width:150px;">
                                <option value="">--Select--</option>
                                <option value="Yes">Yes</option>
                                <option value="No" selected>No</option>
                              </select>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           
                           <tr>
                             <td align="left" valign="middle" class="text1">Verified Date : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="verified_date" type="text" class="datepick textfield121" id="verified_date" readonly/></td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                          
                           <tr>
                             <td align="left" valign="middle" class="text1">Alert Day : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="alert_licence" type="text" class="validate[required] textfield121" id="alert_licence" onKeyPress="return onlyNumbers(event);"/></td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                        	<tr>
                              <td height="10" colspan="4" align="left" class="headingtext"></td>
                            </tr>                        
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="6" align="left"><input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;               					    <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_driving_licence.php'"></td>
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
