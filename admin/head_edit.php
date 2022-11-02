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

if(isset($_SESSION['admin_id'])==""){
	header("location:index.php");
	exit;
}

$firm = $db->fetchSingle("payment_heads", "id='$_REQUEST[id]'");

if(isset($_POST["submit"])<>''){
	
	$num=$db->countRows('payment_heads',"heads='$_POST[firm_name]' AND id!='$_REQUEST[id]'");
	if($num>0){
		
		header("Location:head_edit.php?id=$_REQUEST[id]&msg=exist");
		exit;
	}else{
		//update firms table
		$string="heads='$_POST[firm_name]'";
		$db->updateTable("payment_heads",$string,"id='$_REQUEST[id]'");

		header("Location:head_edit.php?id=$_REQUEST[id]&msg=added");
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
                          <td width="50%" align="left" valign="middle"><h2>Edit Head</h2></td>
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
                           <?php if(isset($_REQUEST["msg"])=='added'){ ?>
                          <span class="success">Record has been updated successfully</span>. 
                          <?php } ?>
                          <?php if(isset($_REQUEST["msg"])=='exist'){ ?>
                           <span class="error">This firm name already exist.</span>
                          <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td width="104" align="left" valign="bottom" class="text1">&nbsp;</td>
                          <td width="755" height="25" align="left" valign="bottom" class="text1">&nbsp;</td>
                          <td width="12" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="text1">Firm Name : </td>
                          <td height="25" align="left" valign="bottom" class="text1">
						  <input name="firm_name" type="text" class="validate[required] textfield2" id="firm_name" value="<?php echo $firm["heads"]; ?>"></td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>						
                        <tr>
                          <td height="10" colspan="4" align="left" class="headingtext"></td>
                        </tr>                        
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="6" align="left"><input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;               					    <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='head_manage.php'"></td>
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
