<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Edit Category';
include 'application_top.php';

//Object initialization
//$dbf = new User();


if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}

$res=$db->fetchSingle("alert_days","id='$_REQUEST[id]'");

if(isset($_POST[submit])<>'')
{
	$num=$db->countRows('alert_days',"alert_type='$_POST[alert_type]' AND id!=$_REQUEST[id]");
	if($num>0)
	{
		header("Location:edit_alert_type.php?id=$_REQUEST[id]&msg=exist");
	}
	else
	{
		//Update alert_days table
		$string="alert_type='$_POST[alert_type]'";
		$db->updateTable("alert_days",$string,"id='$_REQUEST[id]'");
		header("Location:edit_alert_type.php?id=$_REQUEST[id]&msg=updated");
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Edit Alert Type </h2></td>
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
                    <td bgcolor="#e2e2e2">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                      <table width="90%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:10px;">
                   
                        <tr>
                          <td height="30" colspan="4" align="left" valign="middle">
                           <?php if($_REQUEST[msg]=='updated'){ ?>
                          <span class="success">Record has been updated  successfully</span>. 
                          <?php } ?>
                          <?php if($_REQUEST[msg]=='exist'){ ?>
                           <span class="error">This vehicle type already exist. </span>
                          <?php } ?>
                          </td>
                        </tr>
          


                        <tr>
                          <td width="104" align="left" valign="bottom" class="text1">&nbsp;</td>
                          <td width="755" height="25" align="left" valign="bottom" class="text1">&nbsp;</td>
                          <td width="12" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text1">Alert Type : </td>
                          <td height="25" align="left" valign="bottom" class="text1">
						  <input name="alert_type" type="text" class="validate[required] textfield2" id="alert_type" value="<?php echo $res[alert_type]; ?>"></td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
						
                        <tr>
                          <td height="10" colspan="4" align="left" class="headingtext"></td>
                          </tr>
                    
                        
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="6" align="left"><input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;               					    <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_alert_type.php'"></td>
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
