<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//$db = new User();

if(isset($_POST[submit])<>''){
	$string="set_amount ='$_REQUEST[emailid]'";
	$db->updateTable("insurance_cliam",$string,"id='$_REQUEST[eid]'");
	
	$show = $db->fetchSingle("insurance_cliam", "id='$_REQUEST[eid]'");
	?>
	<script type="text/javascript">
        self.parent.location.href='add_all_other_info.php?id=<?php echo $show[vehicle_id];?>';
        self.parent.tb_remove();
    </script>
    <?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script language="javascript" type="text/javascript">
function forgot(){

	if(document.frm.emailid.value=="" || document.frm.emailid.value=="0")
	{
	  alert("Enter  Email ID");
	  document.frm.emailid.focus();
	  return false;
	}		
}	
</script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form id="frm" name="frm" method="post" action="" onSubmit="return forgot()">
  <table width="393" height="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td height="25" colspan="2" align="center" class="fetch_headers">Settlement your Amount</td>
    </tr>    
    <tr>
      <td width="96" height="22" align="center" class="text1"> Amount : </td>
      <td width="277" height="22" align="left"><input name="emailid" type="text" class="textfield2" id="emailid" size="25" autocomplete="off" /></td>
    </tr>
    
    <tr>
      <td height="38" colspan="2" align="center">&nbsp;
        <input name="submit" type="submit" class="button" id="submit"   value="Submit" />
        &nbsp;&nbsp;
      <input name="aaa" type="button" class="button"  onclick="javascript:self.parent.tb_remove();" value="Cancel" /></td></tr>
  </table>
</form>
</body>
</html>
