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

if(isset($_SESSION['admin_id'])=="")
{
  header("location:index.php");
  exit;
}

$res_edit=$db->fetchSingle("other_reminders","id='$_REQUEST[id]'");

if(isset($_POST[submit])<>'')
{
	$vehicle_no=strtoupper($_POST[vehicle_no]);
	$num=$db->countRows('other_reminders',"vehicle_no='$vehicle_no' AND alert_type='$_POST[alert_type]' AND start_date='$_POST[start_date]' AND end_date='$_POST[end_date]' AND id!='$_REQUEST[id]'");
	if($num>0)
	{
		header("Location:edit_other_reminder.php?msg=exist&id=$_REQUEST[id]");
		exit;
	}
	else
	{
		$string="alert_type='$_POST[alert_type]',vehicle_no='$vehicle_no',start_date='$_POST[start_date]',end_date='$_POST[end_date]',amount='$_POST[amount]',remark='$_POST[remark]',paid_date='$_POST[paid_date]',payment_status='$_POST[payment_status]',alert_other='$_POST[alert_other]'";
		$db->updateTable("other_reminders",$string,"id='$_REQUEST[id]'");
		header("Location:edit_other_reminder.php?msg=updated&id=$_REQUEST[id]");
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
        <td width="10">&nbsp;</td>
        <td width="1314" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                          <td width="50%" align="left" valign="middle" style="padding-left:10px;"><h2>Edit Reminder</h2></td>
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
                    <?php if($_REQUEST[msg]=='updated'){ ?>
                      <span class="success">Record has been added  successfully. </span>
                    <?php } ?>
                    
                    <?php if($_REQUEST[msg]=='exist'){ ?>
                      <span class="noRecords2">This Vehicle No. Already Exist. </span>
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
                            <option value="<?php echo $val[alert_type]; ?>" <?php if($res_edit[alert_type]==$val[alert_type]) { echo "Selected"; } ?>><?php echo $val[alert_type]; ?></option>
                             <?php } ?>
                          </select>
                          </td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					    <tr>
					      <td width="99" height="40" align="left" valign="middle">Vehicle No. <span class="startext">*</span> :</td>
					      <td width="162" height="40" align="left" valign="middle">
					        <input name="vehicle_no" type="text" class="validate[required] textfield121" id="vehicle_no" style="text-transform:uppercase;" value="<?php echo $res_edit[vehicle_no];?>"/>
					        </td>
					      <td width="788" height="40" align="left" valign="middle" class="level_msg">(ex. OR02BA6551)</td>
					      </tr>
					    
					    <tr>
					      <td height="40" align="left" valign="middle"> start date <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
					   <input name="start_date" type="text" class="datepick validate[required] textfield121" id="start_date" readonly value="<?php echo $res_edit[start_date];?>"/>                          </td>
					      <td height="40" align="left" valign="middle" class="level_msg">(ex. Y-M-D)</td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle"> end date<span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
					        <input name="end_date" type="text" class="datepick validate[required] textfield121" id="end_date" readonly value="<?php echo $res_edit[end_date];?>"/></td>
					      <td height="40" align="left" valign="middle" class="level_msg">(ex. Y-M-D)</td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Amount <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
					        <input name="amount" type="text" class="validate[required] textfield121" id="amount" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_edit[amount];?>"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					   
					    <tr>
					      <td height="40" align="left" valign="middle">Remark :</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      </tr>
					    <tr>
					      <td height="40" colspan="3" align="left" valign="middle">
                        <textarea  rows="5" cols="50" style="border:1px solid #999;" name="remark" id="remark" class="validate[required]"><?php echo $res_edit[remark];?></textarea>
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
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">Alert Day :* </td>
                          </tr>
                        
                        <tr>
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">
                         <input name="alert_other" type="text" class="validate[required] textfield121" id="alert_other" autocomplete="off" onKeyPress="return onlyNumbers(event);" value="<?php echo $res_edit[alert_other];?>"/>
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
        <td width="19">&nbsp;</td>
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
