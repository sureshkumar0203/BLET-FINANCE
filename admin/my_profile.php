<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='My Profile';
include 'application_top.php';
//Object initialization
//$db = new User();

if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}

$res=$db->fetchSingle("admin","id='1'");

if(isset($_POST[submit])<>'')
{
	$string="admin_name='$_POST[admin_name]',email='$_POST[email]'";
	$db->updateTable("admin",$string,"id='1'");
	header("Location:my_profile.php?msg=added");
}

?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle" ><?php include 'header.php'; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="3" align="left" valign="top"></td>
            </tr>
          <tr>
            <td width="226" align="left" valign="top" height="365"><?php include 'left.php';?></td>
            <td width="10">&nbsp;</td>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>My Profile</h2></td>
                          <td width="50%" align="right" valign="middle"><h2>&nbsp;</h2></td>
                        </tr>
                      </table>
					  </td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table>
				</td>
              </tr>
			  
              <tr>
                <td align="left" valign="top" bgcolor="#e2e2e2" height="320">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td width="1038">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                      <table width="92%" height="191" border="0" align="left" cellpadding="0" cellspacing="0">
                   
                    
                        <tr>
                          <td height="30" align="left" class="headingtext">&nbsp;</td>
                          <td height="30" colspan="2" align="left" valign="middle" class="success">
                          <?php if($_REQUEST[msg]=='added'){ ?>
                          Your profile has been updated successfully.  <?php } ?>
                          </td>
                        </tr>
                       
                        <tr>
                          <td width="13" height="30" align="left" class="headingtext">&nbsp;</td>
                          <td width="122" height="30" align="left" valign="middle" class="text1">Admin Name :* </td>
                          <td width="836" colspan="2" align="left" valign="middle"><input name="admin_name" type="text" class="validate[required] textfield2" id="admin_name" value="<?=$res[admin_name];?>" autocomplete="off" style="width:260px;"/></td>
                        </tr>
                        <tr>
                          <td width="13" height="30" align="left" class="headingtext">&nbsp;</td>
                          <td width="122" height="30" align="left" valign="middle" class="text1">Email Address  :* </td>
                          <td height="30" colspan="2" align="left" valign="middle"><input name="email" type="text" class="validate[required,custom[email]] textfield2" id="email" value="<?=$res[email];?>" autocomplete="off" style="width:260px;"/></td>
                        </tr>

                        
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="5" align="left" valign="bottom"><input name="submit" type="submit" class="button" id="submit" value="Submit">                            &nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                          <td colspan="5" align="left">&nbsp;</td>
                        </tr>
                      </table>
                    </form>
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
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  
                </table>
                  </td>
              </tr>
			  
              <tr>
                <td align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="5" align="left" valign="top"><img src="images/bottom-left-box-bg.jpg" alt="bot_left_bg" width="5" height="5" /></td>
                      <td height="5" class="botmidboxbg"></td>
                      <td width="5"><img src="images/bot-right-box-bg.jpg" alt="bot_right" width="5" height="5" /></td>
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
