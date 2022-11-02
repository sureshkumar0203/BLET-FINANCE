<?
ob_start();
session_start();
include_once '../includes/class.Main.php';
include_once '../includes/class.Email.php';

$user = new User();
$dbf = new Dbfunctions();



if(isset($_POST[submit])<>'')
{

	$emailid=addslashes($_POST[emailid]);
	if(($dbf->existsInTable("admin","email='$emailid'"))==0)
	{
		header("Location:forgot_password.php?msg=fail");
	}
	else
	{
		$res=$dbf->fetchSingle("admin","email='$emailid'");
		$password=$res[password];

		$from=$res[email];
		$email=$res[email];

		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From:".$from."\n";
	
	
	  //echo $recipient;exit;
	  $baseUrl=$res[site_url];	
	  $imgPath=$baseUrl."/admin/images/logo.png";//exit;
	  
	  $body='<table width="940" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #CCCCCC">
<tr>
  <td valign="top">&nbsp;</td>
</tr>

<tr>
  <td align="left" style="padding-left:10px;"></td>
</tr>
<tr>
  <td align="left" style="padding-left:10px;">&nbsp;</td>
</tr>
<tr>
  <td align="left" style="padding-left:10px;">&nbsp;</td>
</tr>

<tr>
  <td align="left" style="padding-left:10px;"><strong>Your Administrator Password is  :</strong> '.$password.'</td>
</tr>
<tr>
  <td height="35" style="padding-left:10px;">&nbsp;</td>
</tr>
<tr>
  <td height="35" style="padding-left:10px;"><strong>With Best Wishes,</strong></td>
</tr>

<tr>
  <td height="8" style="padding-left:10px;"><strong><font color="#a0792c">'.$res[admin_name].'</font></strong></td>
</tr>
<tr>
  <td height="8" style="padding-left:10px;"><strong> Mail : '.$res[alt_email].'</strong></td>
</tr>
<tr>
  <td height="8" style="padding-left:10px;"> <strong> Website : '.$res[site_url].'</strong></td>
</tr>
<tr>
  <td height="8">&nbsp;</td>
</tr>

</table>';
	//echo $body;
	//exit;


	$subject = "Password Recovery";
	
	if(mail($email,$subject,$body,$headers))
	{
		header("Location:forgot_password.php?msg=sent");
		exit;
	}
}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script language="javascript" type="text/javascript">
function forgot(){
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
var emailid=document.frm.emailid.value;
if(document.frm.emailid.value=="")
{
  alert("Enter  Email ID");
  document.frm.emailid.focus();
  return false;
}	
if(!emailid.match(emailExp))
{
  alert("Enter valid Email ID");
  document.frm.emailid.focus();
  return false;
}	
	
}	
</script>

<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<? if($_REQUEST[msg]<>'sent') {?>
<form id="frm" name="frm" method="post" action="" onSubmit="return forgot()">
  <table width="393" height="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td height="25" colspan="2" align="center" class="fetch_headers">Recover Your Password </td>
    </tr>
  
    <tr>
      <td height="28" colspan="2" align="center" valign="middle" class="style56" style="padding-left:4px"><p class="text2" >Your password will be sent to your Email ID.</p></td>
    </tr>
    
	<?
	if($_REQUEST[msg]=='fail')
	{
	?>
	<tr>
      <td height="18" colspan="2" align="center" valign="top" class="noRecords2" >Email ID didn't match.</td>
    </tr>
	<?
	}
	?>
    
    <tr>
      <td width="96" height="22" align="center" class="text1"> Email ID : </td>
      <td width="277" height="22" align="left"><input name="emailid" type="text" class="textfield2" id="emailid" size="25" autocomplete="off" /></td>
    </tr>
    
    <tr>
      <td height="38" colspan="2" align="center">&nbsp;
        <input name="submit" type="submit" class="button" id="submit"   value="Submit" />
        &nbsp;&nbsp;
      <input name="aaa" type="button" class="button"  onclick="javascript:self.parent.tb_remove();" value="Cancel" /></td></tr>
  </table>
  
</form><? } ?>

<? if($_REQUEST[msg]=='sent') {?>
<table width="393" height="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td height="25" colspan="2" align="center" background="images/tableback.jpg" bgcolor="#FFFFFF" >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="center" background="images/tableback.jpg" bgcolor="#FFFFFF" class="fetch_headers" >Recover Your Password </td>
    </tr>
    <!-- <tr>
    <td height="21" colspan="5" bgcolor="#000033" class="style22"><marquee direction="right" behavior="alternate"ss	>This is the chance....</marquee></td>
  </tr>-->
    <tr>
      <td width="70" height="28" align="right" valign="middle" class="style56" style="padding-left:4px"><p class="text2" ><img src="images/green_tick_icon.jpg" width="25" height="23" /></p></td>
      <td width="303" height="28" align="left" valign="middle" class="style56" style="padding-left:4px"><span class="text2"><span class="suc_msg">Your password has been sent to your Email ID </span></span></td>
    </tr>
    
	<?
	if($_REQUEST[msg]=='fail')
	{
	?>
	
	<?
	}
	?>
    

    <tr>
      <td height="38" colspan="2" align="center">&nbsp;&nbsp;&nbsp;
      <input name="aaa" type="button" class="button"  onclick="javascript:self.parent.tb_remove();" value="Close" /></td></tr>
  </table>
  <? } ?>
</body>
</html>
