<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Edit payment status & Remark';
include 'application_top.php';
//Object initialization
//$db = new User();

if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}

//Installment Details  
$res_edit=$db->fetchSingle("installment_details","id='$_REQUEST[id]'");

//Vehicle Information 
$veh_info=$db->fetchSingle(" new_vehicle_registration","id='$res_edit[vehi_id]'");

//Vehicle Type : Crane , Truck
$veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vtype]'"); 

if(isset($_POST[submit])<>'')
{
	$string="remark='$_POST[remark]',payment_status='$_REQUEST[payment_status]',paid_date='$_REQUEST[paid_date]'";
	$db->updateTable("installment_details",$string,"id='$_REQUEST[id]'");
	header("Location:edit_payment_info.php?msg=updated&id=$_REQUEST[id]");
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
                          <td width="50%" align="left" valign="middle"><h2>Edit payment status & Remark</h2></td>
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
                    <td align="center" valign="top">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                      <table width="100%" height="191" border="0" align="left" cellpadding="0" cellspacing="0">
                   
                      <?php if($_REQUEST[msg]=='updated')
					  {
					  ?>
                        <tr>
                          <td height="30" colspan="2" align="left" valign="middle" class="success">Record has been updated successfully. </td>
                        </tr>
                        <?php
						}
						?>
                       
                      
                       
                        <tr>
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="20%" align="left" valign="top">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #999;">
                          <tr>
                            <td height="10" class="text1" style="padding-left:10px;"></td>
                            <td height="10" align="center" valign="middle" class="text1"></td>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td width="49%" height="25" class="text1" style="padding-left:10px;">Vehicle No.</td>
                            <td width="6%" align="center" valign="middle" class="text1">:</td>
                            <td width="45%" height="25" class="text25"><?php echo $veh_info[vehicle_no]; ?></td>
                          </tr>
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Vehicle type</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25" class="text25"><?php echo $veh_type[vtype]; ?></td>
                          </tr>
                          
                            <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Installment Date</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25" class="text25"><?php echo date("jS M,Y",strtotime($res_edit[next_payment_date])); ?></td>
                          </tr>
                          
                            <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Payment Status</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25">
							 <?php if($res_edit[payment_status]=="Paid") { ?>
                            <font color="#009900"><?php echo $res_edit[payment_status]; ?></font> <?php } else { ?>
                            <font color="#FF0000"><?php echo $res_edit[payment_status]; ?></font> <?php } ?>
							 </td>
                          </tr>
                          <tr>
                            <td height="10" class="text1" style="padding-left:10px;"></td>
                            <td height="10" align="center" valign="middle" class="text1"></td>
                            <td height="10"></td>
                          </tr>
                        </table>
                          </td>
                          <td width="30%" style="padding-left:10px; padding-right:10px;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #999;">
                        <tr>
                          <td height="10" class="text1" style="padding-left:10px;"></td>
                          <td height="10" align="center" valign="middle" class="text1"></td>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td width="55%" height="25" class="text1" style="padding-left:10px;">Finance By</td>
                          <td width="5%" align="center" valign="middle" class="text1">:</td>
                          <td width="40%" height="25"><?php echo $veh_info[finance_by]; ?></td>
                          </tr>
                        
                        <tr>
                          <td height="25" class="text1" style="padding-left:10px;">Finance amount</td>
                          <td align="center" valign="middle" class="text1">:</td>
                          <td height="25">Rs. <?php echo $veh_info[finance_amount]; ?></td>
                          </tr>
                        <tr>
                          <td height="25" class="text1" style="padding-left:10px;">Interest amount</td>
                          <td align="center" valign="middle" class="text1">:</td>
                          <td height="25">Rs. <?php echo $veh_info[interest_amount]; ?></td>
                          </tr>
                        <tr>
                          <td height="25" class="text1" style="padding-left:10px;">Total amount paid to bank</td>
                          <td align="center" valign="middle" class="text1">:</td>
                          <td height="25">Rs. <?php echo $veh_info[total_amount_paid_to_bank]; ?></td>
                          </tr>
                        <tr>
                          <td height="10" class="text1" style="padding-left:10px;"></td>
                          <td height="10" align="center" valign="middle" class="text1"></td>
                          <td height="10"></td>
                        </tr>
                          </table>
                          </td>
                          <td width="27%" style="padding-left:10px; padding-right:10px;" valign="top">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #999;">
                          <tr>
                            <td height="10" class="text1" style="padding-left:10px;"></td>
                            <td height="10" align="center" valign="middle" class="text1"></td>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td width="62%" height="25" class="text1" style="padding-left:10px;">Payment Bank</td>
                            <td width="5%" align="center" valign="middle" class="text1">:</td>
                            <td width="33%" height="25"><?php echo $veh_info[payment_bank]; ?></td>
                            </tr>
                          
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Loan A/C No.</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25" class="text25"><?php echo $veh_info[loan_ac_no]; ?></td>
                          </tr>
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Installment amount / Month</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25" class="text25">Rs. <?php echo $veh_info[installment_per_month]; ?></td>
                            </tr>
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Farm Name</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25"><?php echo $veh_info[farm_name]; ?></td>
                            </tr>
                          <tr>
                            <td height="10" class="text1" style="padding-left:10px;"></td>
                            <td height="10" align="center" valign="middle" class="text1"></td>
                            <td height="10"></td>
                          </tr>
                          
                          </table>
                          </td>
                          <td width="23%" style="padding-left:10px; padding-right:10px;" valign="top">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #999;">
                          <tr>
                            <td height="10" class="text1"></td>
                            <td height="10" align="center" valign="middle" class="text1"></td>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td width="50%" height="25" class="text1" style="padding-left:10px;">Loan Start Date</td>
                            <td width="6%" align="center" valign="middle" class="text1">:</td>
                            <td width="44%" height="25">
							<?php $lsd=strtotime($veh_info[loan_start_date]);echo date("jS M,Y",$lsd);?>
							</td>
                          </tr>
                          
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Loan End Date</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25">
							<?php $led=strtotime($veh_info[loan_end_date]);echo date("jS M,Y",$led);?>
							</td>
                          </tr>
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">No. of installment</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25"><?php echo $veh_info[no_of_installment]; ?></td>
                          </tr>
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Rate of interest</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25"><?php echo $veh_info[rate_of_interest]; ?> % </td>
                          </tr>
                          <tr>
                            <td height="10" class="text1"></td>
                            <td height="10" align="center" valign="middle" class="text1"></td>
                            <td height="10"></td>
                          </tr>
                          
                        </table>
                          </td>
                        </tr>
                      </table>
                          </td>
                          </tr>
                        <tr>
                          <td width="108" height="30" align="left" valign="middle" class="text1">Remark :* </td>
                          <td width="841" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3" align="left" valign="middle" class="text1">
                    <textarea  rows="5" cols="50" style="border:1px solid #999;" name="remark" id="remark" class="validate[required]"><?php echo $res_edit[remark]; ?></textarea>
                          </td>
                          </tr>
                          
						 <tr>
						   <td height="30" colspan="3" align="left" valign="middle" class="text1">Payment Date :*<span class="level_msg">(ex. Y-M-D) </span></td>
						   </tr>
						 <tr>
						   <td height="30" colspan="3" align="left" valign="middle" class="text1">
                           <?php 
						   if($res_edit[paid_date]!="0000-00-00") { 
						   $paid_date=$res_edit[paid_date];
						   }else{
							   $paid_date="";
						   }
						   ?>
                          <input name="paid_date" type="text" class="datepick validate[required] textfield121" id="paid_date" value="<?php echo $paid_date; ?>" readonly/>
                           </td>
						   </tr>
						 <tr>
                          <td width="108" height="30" align="left" valign="middle" class="text1">Payment Status :* </td>
                          <td width="841" colspan="2" align="left" valign="middle">&nbsp;</td>
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
                          <td height="30" colspan="6" align="left">&nbsp;</td>
                          </tr>
                        <tr>
                          <td height="40" colspan="6" align="left">
                          <input name="submit" type="submit" class="button" id="submit" value="Submit">
                          &nbsp;&nbsp;
                          <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='vehicle_details.php?id=<?php echo $res_edit[vehi_id];?>'">
                          </td>
                          </tr>
                        <tr>
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
