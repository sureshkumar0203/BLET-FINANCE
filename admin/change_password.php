<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Change Password';
include 'application_top.php';
//Object initialization
//$dbf = new User();

if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}

if(isset($_POST["submit"])<>'')
{
	$string="password='$_POST[password]'";
	$db->updateTable("admin",$string,"id='1'");
	header("Location:change_password.php?msg=added");
}
?>
<script language="javascript" type="text/javascript">
 <!--START OF RESTRICTING XSS CODE FOR PASSWORD -->
function chk_xss_pw(xss)
{
	var maintainplus = '';
  	var numval = xss.value
	curphonevar = numval.replace(/[\\<>&\/\]\[]/g,'');
	xss.value = maintainplus + curphonevar;
	var maintainplus = '';
	xss.focus;
}
<!--END OF RESTRICTING XSS CODE FOR PASSWORD-->
</script>
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
              <tr>
                <td align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Change Password</h2></td>
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
                <td align="left" valign="top" height="320">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                      <table width="92%" height="191" border="0" align="left" cellpadding="0" cellspacing="0">
                   
                     
                        <tr>
                          <td height="30" align="left" class="headingtext">&nbsp;</td>
                          <td height="30" colspan="3" align="left" valign="middle" class="success">
                           <?php if(isset($_REQUEST["msg"])=='added') { ?>
                          Password has been updated successfully.
                           <?php } ?>
                          </td>
                        </tr>
                       
                        <tr>
                          <td width="19" height="30" align="left" class="headingtext">&nbsp;</td>
                          <td width="137" height="30" align="left" valign="middle" class="text1">New Password<span class="startext">*</span>  : </td>
                          <td width="772" colspan="2" align="left" valign="middle">
						  <input name="password" type="password" class="validate[required] textfield2" id="password" onKeyUp="chk_xss_pw(this);"></td>
                        </tr>
                        <tr>
                          <td width="19" height="30" align="left" class="headingtext">&nbsp;</td>
                          <td width="137" height="30" align="left" valign="middle" class="text1">Confirm Password <span class="startext">*</span>   : </td>
                          <td height="30" colspan="2" align="left" valign="middle">
						  <input name="repassword" type="password" class="validate[required,equals[password]] textfield2" id="repassword" onKeyUp="chk_xss_pw(this);"></td>
                        </tr>
                       
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="5" align="left" valign="bottom">
						  <input name="submit" type="submit" class="button" id="submit" value="Change Password">
						 </td>
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
