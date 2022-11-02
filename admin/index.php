<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Admin Panel';
include 'application_top.php';

//Check whether user is logged in or not
//$dbf = new User();
if ($db->get_session()){
	header("location:admin_home.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$email=addslashes($_POST['email']);
	$password=addslashes($_POST['password']);
	
	$login = $db->check_login($email,$password);
	if ($login){
		// Login Success
		header("location:index.php");
	}else{
		// Login Failed
		$msg= 'fail';
	}
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
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td height="500" align="center" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td align="center" class="topheader"><?php include 'header.php';?></td>
      </tr>
      <tr>
        <td height="40" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top">
		<form action="" method="post" id="frm" name="frm">
		  <table width="424" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tableborder">
          <tr>
            <td height="50" align="left" valign="middle" background="images/head_bg.jpg" bgcolor="#384241" class="logintext"> Admin Login </td>
          </tr>
          <tr>
            <td height="130" align="center" valign="top">
           
            
            <table width="380" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30" colspan="4" align="center"><?php if(isset($msg)=='fail'){?><span class="error">Invalid Email ID or Password </span><?php } ?></td>
                  </tr>
                <tr>
                  <td width="60" align="left" valign="top"><img src="images/login-img.jpg" alt="login-img" width="50" height="75" /></td>
                  <td width="30">&nbsp;</td>
                  <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="31%" align="right" valign="middle">Email ID :</td>
                        <td width="3%">&nbsp;</td>
                        <td width="66%" align="left" valign="middle">
						<input name="email" type="text" class="textfield validate[required,custom[email]]" id="email" size="45"/>
                        </td>
                      </tr>
                      <tr>
                        <td height="5" colspan="3" align="right" valign="middle"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Password :</td>
                        <td>&nbsp;</td>
                        <td align="left" valign="middle">
						<input name="password" type="password" class="textfield validate[required]" id="password" size="45" onKeyUp="chk_xss_pw(this);"/></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="1" colspan="4" bgcolor="#dddddd"></td>
                </tr>
                <tr>
                  <td height="10" colspan="4"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="right" valign="top" style="padding-right:8px;"><input type="image" src="images/sign-in_btn.jpg"></td>
                </tr>
                <tr>
                  <td colspan="4" align="left" valign="middle">
                  <!--<a href="forgot_password.php?page=forgot_password.php&amp;TB_iframe=true&amp;height=190&amp;width=365&amp;inlineId=hiddenModalContent&amp;modal=true" class="forgottext thickbox">Forgot your password?</a>--></td>
                </tr>
            </table>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
		</form></td>
      </tr>
    </table></td>
  </tr>
   <?php include 'footer.php';?>
</table>
</body>
</html>
