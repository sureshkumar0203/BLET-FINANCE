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


if(isset($_POST['submit'])<>''){

	$vehicle_no=$db->mysqli->real_escape_string($_POST[vehicle_no]);
	
	$string="name='$vehicle_no'";
	$ins_id=$db->insertSet("insurance_step",$string);
	
	header("Location:insu_step_manage.php");
	exit;
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle" style="padding-left:10px;"><h2>Add New Step</h2></td>
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
                    <td height="30" align="left" valign="middle" style="padding-left:20px;">
                    <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='added'){ ?>
                      <span class="success">Record has been added  successfully. </span>
                    <?php } ?>                                        
                      </td>
                  </tr>
                  <tr>
                    <td valign="top" style="padding-left:20px;">
					<form action="" method="post" id="frm">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					    <tr>
					      <td width="14%" height="40" align="left" valign="top">Step Description :<span class="level_msg"></span></td>
					      <td width="86%" height="40" align="left" valign="middle"><textarea name="vehicle_no" class="validate[required] textfield121" id="vehicle_no" style="border:solid 1px; border-color:#CCC; width:550px; height:200px;" autocomplete="off"></textarea></td>
					      </tr>
					    <tr>
					      <td height="40" colspan="2" align="left" valign="middle">
					        <input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
					        <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='insu_step_manage.php'">
					        </td>
					      </tr>
					    <tr>
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
                <td align="left" valign="top"></td>
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
