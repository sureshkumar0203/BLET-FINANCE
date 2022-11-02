<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
$pageTitle='Admin Panel';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
include 'application_top.php';

//Object initialization
//$dbf = new User();

if(isset($_SESSION['admin_id'])=="")
{
  header("location:index.php");
  exit;
}


if(isset($_POST[submit])<>'')
{
	$vehicle_no=strtoupper($_POST[vehicle_no]);
	$num=$db->countRows('other_reminders',"vehicle_no='$vehicle_no' AND alert_type='$_POST[alert_type]' AND start_date='$_POST[start_date]' AND end_date='$_POST[end_date]'");
	if($num>0)
	{
		header("Location:add_other_reminder.php?msg=exist");
		exit;
	}
	else
	{
		$string="alert_type='$_POST[alert_type]',vehicle_no='$vehicle_no',start_date='$_POST[start_date]',end_date='$_POST[end_date]',amount='$_POST[amount]',remark='$_POST[remark]',paid_date ='$_POST[paid_date]',payment_status='$_POST[payment_status]',alert_other='$_POST[alert_other]'";
		$ins_id=$db->insertSet("other_reminders",$string);
		header("Location:manage_other_reminder.php");
		exit;
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
        <td width="9">&nbsp;</td>
        <td width="1305" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="3" align="left" valign="top"></td>
            </tr>
          <tr>
            <td width="226" align="left" valign="top" height="365"><?php include 'left.php';?></td>
            <td width="10">&nbsp;</td>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle" style="padding-left:10px;"><h2>Add Reminder</h2></td>
                          <td width="50%" align="right" valign="middle"></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#e2e2e2" height="320">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="righttableborder2">
                  <tr>
                    <td height="30" align="left" valign="middle" bgcolor="#e2e2e2" style="padding-left:20px;">
                    <?php if($_REQUEST[msg]=='added'){ ?>
                      <span class="successMessage">Record has been added  successfully. </span>
                    <?php } ?>
                    
                    <?php if($_REQUEST[msg]=='exist'){ ?>
                      <span class="noRecords2">This vehicle No. start sate & end date already exist. </span>
                    <?php } ?>
                    
                      </td>
                  </tr>
                  <tr>
                    <td bgcolor="#e2e2e2" valign="top" style="padding-left:20px;">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					    <tr>
					      <td height="40" align="left" valign="middle">Alert Type<span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <select name="alert_type" class="validate[required]" id="alert_type" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('alert_days',"id!=1","alert_type","","") as $val) { ?>
                            <option value="<?php echo $val[alert_type]; ?>"><?php echo $val[alert_type]; ?></option>
                             <?php } ?>
                          </select>
                          </td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					    <tr>
					      <td width="118" height="40" align="left" valign="middle">
                           Vehicle No<span class="startext">*</span> :<br>
						  <span class="level_msg">(ex. OR02BA6551) </span>
                          </td>
					      <td width="155" height="40" align="left" valign="middle">
					        <input name="vehicle_no" type="text" class="validate[required] textfield121" id="vehicle_no" style="text-transform:uppercase;"/>
					        </td>
					      <td width="776" height="40" align="left" valign="middle" class="level_msg">&nbsp;</td>
					      </tr>
					    
					    <tr>
					      <td height="40" align="left" valign="middle"> 
                          Start date <span class="startext">*</span> :<br>
						  <span class="level_msg">(ex. Y-M-D) </span>
                          </td>
					      <td height="40" align="left" valign="middle">
					       <input name="start_date" type="text" class="datepick validate[required] textfield121" id="start_date" readonly/></td>
					      <td height="40" align="left" valign="middle" class="level_msg">&nbsp;</td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle"> 
                          End date<span class="startext">*</span> :<br>
						  <span class="level_msg">(ex. Y-M-D) </span>
                          </td>
					      <td height="40" align="left" valign="middle">
					        <input name="end_date" type="text" class="datepick validate[required] textfield121" id="end_date" readonly/></td>
					      <td height="40" align="left" valign="middle" class="level_msg">&nbsp;</td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Amount <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
					        <input name="amount" type="text" class="validate[required] textfield121" id="amount" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					   
					    <tr>
					      <td height="40" align="left" valign="middle">Remark :</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					    <tr>
					      <td height="40" colspan="3" align="left" valign="middle">
                          <textarea  rows="5" cols="50" style="border:1px solid #999;" name="remark" id="remark" class="validate[required]"></textarea>
                          </td>
					      </tr>
                          
                           <tr>
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">Payment Status :* </td>
                          </tr>
                        
                        <tr>
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">
                          <select name="payment_status" class="validate[required]" id="payment_status" style="border:1px solid #CCC; height:25px; width:150px;">
                          <option value="">--Select--</option>
                          <option value="Paid" <?php if($res_edit[payment_status]=="Paid") { echo "Selected"; } ?>>Paid</option>
                          <option value="Unpaid" <?php if($res_edit[payment_status]=="Unpaid") { echo "Selected"; } ?>>Unpaid</option>
					      </select>
                          </td>
                          </tr>

                           <tr>
                             <td height="30" colspan="3" align="left" valign="middle" class="text1">
                             Payment Date :*<span class="level_msg">(ex. Y-M-D) </span>
                             </td>
                           </tr>
                           <tr>
                             <td height="30" colspan="3" align="left" valign="middle" class="text1">
                           <input name="paid_date" type="text" class="datepick validate[required] textfield121" id="paid_date" value="<?php echo $res_edit[paid_date];?>" readonly/>
                             </td>
                           </tr>
                           
                             <tr>
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">Alert Day :* </td>
                          </tr>
                        
                        
                        <tr>
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">
                         <input name="alert_other" type="text" class="validate[required] textfield121" id="alert_other" autocomplete="off" onKeyPress="return onlyNumbers(event);"/>
                          </td>
                          </tr>
                          
                          
					    <tr>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					    <tr>
					      <td height="40" colspan="3" align="left" valign="middle">
                          <input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
                           <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_other_reminder.php'">
                          </td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					    </table>
					</form>
                    </td>
                  </tr>
                </table>
				</td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="5" align="left" valign="top"><img src="images/bottom-left-box-bg.jpg" alt="bot_left_bg" width="5" height="5" /></td>
                      <td height="5" class="botmidboxbg"></td>
                      <td width="5"><img src="images/bot-right-box-bg.jpg" alt="bot_right" width="5" height="5" /></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
        <td width="29">&nbsp;</td>
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
