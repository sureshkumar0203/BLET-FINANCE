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

$view_det=$db->fetchSingle("other_details","id='$_REQUEST[id]'"); 


if(isset($_POST['submit'])<>'')
{
	//insert to other_details table
	$string="firm_id='$_REQUEST[firm_id]',payment_head_id='$_REQUEST[payment_head_id]',paid_to='$_REQUEST[paid_to]',amount='$_REQUEST[amount]',mode_of_payment='$_REQUEST[mode_of_payment]',bank_id='$_REQUEST[bank_id]',cheque_no='$_REQUEST[cheque_no]',payment_date='$_REQUEST[payment_date]',date_from='$_REQUEST[date_from]',date_to='$_REQUEST[date_to]',alert_others='$_REQUEST[alert_others]',remarks='$_REQUEST[remarks]'";
	$db->updateTable("other_details",$string,"id='$_REQUEST[id]'");
	header("Location:edit_others.php?id=$_REQUEST[id]&msg=updated");
	exit;
}
?>
<script language="javascript" type="text/javascript">
function showHide(mode)
{
	if(mode=="Cheque")
	{
		document.getElementById('tr_bank').style.display='';
	}
	if(mode=="Draft") 
	{
		document.getElementById('tr_bank').style.display='';
	}
	
	if(mode=="Cash") 
	{
		document.getElementById('tr_bank').style.display='none';
	}
}
</script>	

</script>
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
                          <td width="50%" align="left" valign="middle"><h2>Edit Others</h2></td>
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
                          <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='updated'){ ?>
                          <span class="success">Record has been updated successfully</span>. 
                          <?php } ?>
                       
                          </td>
                        </tr>
                        
                             
                       <tr>
                         <td align="left" valign="middle" class="text1">Firm Name : </td>
                         <td height="30" align="left" valign="bottom" class="text1">
                         <select name="firm_id" class="validate[required]" id="firm_id" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('firms',"","firm_name","","") as $val) { ?>
                            <option value="<?php echo $val['id']; ?>" <?php if($view_det['firm_id']==$val['id']) { echo "Selected"; }?>><?php echo $val['firm_name']; ?></option>
                             <?php } ?>
                          </select>
                         </td>
                         <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                       </tr>
                       
                       <tr>
                         <td align="left" valign="middle" class="text1">Payment Head : </td>
                         <td height="30" align="left" valign="bottom" class="text1">
                         <select name="payment_head_id" class="validate[required]" id="payment_head_id" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('payment_heads',"","heads","","") as $val_head) { ?>
                            <option value="<?php echo $val_head['id']; ?>" <?php if($view_det['payment_head_id']==$val_head['id']) { echo "Selected"; }?>><?php echo $val_head['heads']; ?></option>
                             <?php } ?>
                          </select>
                         </td>
                         <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                       </tr>
                           
                        <tr>
                          <td align="left" valign="middle" class="text1">Paid to  : </td>
                          <td height="30" align="left" valign="bottom" class="text1">
                          <input name="paid_to" type="text" class="validate[required] textfield121" id="paid_to" style="text-transform:uppercase;" autocomplete="off" value="<?php echo $view_det['paid_to']; ?>"/>
                          </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                         </tr>
                         
                         <tr>
                          <td width="17%" align="left" valign="middle" class="text1"> Amount : </td>
                          <td width="64%" height="30" align="left" valign="bottom" class="text1">
                            <input name="amount" type="text" class="validate[required] textfield121" id="amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $view_det['amount']; ?>"/>
                          </td>
                          <td width="19%" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>

                        <tr>
                          <td align="left" valign="middle" class="text1">Payment Mode : </td>
                          <td height="30" align="left" valign="bottom" class="text1">
           <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHide(this.value);" style="border:1px solid #CCC; height:25px; width:150px;">
                          <option value="Cash" <?php if($view_det['mode_of_payment']=="Cash") { echo "Selected"; }?>>Cash</option>
                          <option value="Cheque" <?php if($view_det['mode_of_payment']=="Cheque") { echo "Selected"; }?>>Cheque</option>
                          <option value="Draft" <?php if($view_det['mode_of_payment']=="Draft") { echo "Selected"; }?>>Draft</option>
                          </select>
                          </td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>

                           <tr id="tr_bank" style="display:<?php if($view_det['mode_of_payment']!="Cash") { ?>''<?php } else { ?>none;<?php } ?>">
                             <td height="10" colspan="4" align="left" class="headingtext">
                            <table width="90%" border="0" align="left" cellpadding="0" cellspacing="0">
                             <tr>
                             <td width="19%" align="left" valign="middle" class="text1">Bank Name : </td>
                             <td width="77%" height="30" align="left" valign="bottom" class="text1">
                             <select name="bank_id" id="bank_id" class="validate[required]" style="border:1px solid #CCC; height:25px; width:150px;">
                             <option value="">--Select--</option>
                             <?php foreach($db->fetch('bank_details',"","bank_name","","") as $val_bank) { ?>
                              <option value="<?php echo $val_bank['id'];?>" <?php if($view_det['bank_id']==$val_bank['id']) { echo "Selected"; }?>><?php echo $val_bank['bank_name'];?></option>
                             <?php } ?>
                              </select>
                             </td>
                             <td width="4%" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           
                            <tr>
                             <td align="left" valign="middle" class="text1">Cheque No. : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="cheque_no" type="text" id="cheque_no" class="validate[required] textfield121" value="<?php echo $view_det['cheque_no']; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                             </table>
                             
                             </td>
                           </tr>
                           
                           
                           <tr>
                             <td align="left" valign="middle" class="text1">Payment Date  : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                 <input name="payment_date" type="text" id="payment_date" class="datepick validate[required] textfield121" readonly value="<?php echo $view_det['payment_date']; ?>"/>
                          <span class="level_msg">(yyyy-m-d) </span>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Date from : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
              <input name="date_from" type="text" id="date_from" class="datepick validate[required] textfield121" readonly value="<?php echo $view_det['date_from']; ?>"/>
                          <span class="level_msg">(yyyy-m-d) </span>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Date to : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                        <input name="date_to" type="text" id="date_to" class="datepickFuture validate[required] textfield121" readonly value="<?php echo $view_det['date_to']; ?>"/>
                          <span class="level_msg">(yyyy-m-d) </span>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           
                           <tr>
                             <td align="left" valign="middle" class="text1">Alert Day : </td>
                             <td height="30" align="left" valign="bottom" class="text1"><input name="alert_others" type="text" class="validate[required] textfield121" id="alert_others" onKeyPress="return onlyNumbers(event);" value="<?php echo $view_det['alert_others']; ?>"/></td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           
                           
                           <tr>
                             <td align="left" valign="top" class="text1">Remarks : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>

                           <tr>
                             <td height="10" colspan="4" align="left" class="headingtext">
                             <textarea name="remarks" id="remarks" rows="4" cols="40" style="border:1px solid #CCC;"><?php echo $view_det['remarks']; ?></textarea></td>
                           </tr>
                           
                           <tr>
                          <td height="10" colspan="4" align="left" class="headingtext"></td>
                          </tr>
                    
                        
                        <tr>
                          <td height="40" colspan="7" align="left">
                          <input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;<input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_others.php'">
                          </td>
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
