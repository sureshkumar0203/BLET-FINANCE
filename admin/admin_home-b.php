<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
$pageTitle='DASHBOARD';
include 'application_top.php';
//Object initialization
$dbf = new User();

if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
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
                          <td width="50%" align="left" valign="middle"><h2>DASHBOARD</h2></td>
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
                    <td height="7" colspan="3"></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top" class="white_heading">Finance Reminder</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="1055" align="left" valign="top" height="35">
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                      <tr bgcolor="#999999" class="text1">
                        <td align="center">Sl. No.</td>
                        <td height="30" style="padding-left:5px;">Vehicle No.</td>
                        <td height="30" style="padding-left:5px;">Vehicle Type</td>
                        <td height="30" style="padding-left:5px;">Installment Amount</td>
                        <td height="30" style="padding-left:5px;">Payment Date</td>
                        <td height="30" style="padding-left:5px;">Finance By</td>
                        <td height="30" style="padding-left:5px;">Payment Bank</td>
                        <td height="30" style="padding-left:5px;">Loan A/C No.</td>
                        <td height="30" style="padding-left:5px;">Farm Name</td>
                        <td align="center">Action</td>
                      </tr>
                       <?php
					   //SELECT * FROM `installment_details` WHERE `next_payment_date` between '2009-10-25' AND '2009-11-04'
					   $finance_rem_day=$dbf->fetchSingle("admin","id='1'");
					   $alert_finance=$finance_rem_day[alert_finance]; 
					   
					   $todate=date("Y-m-d");
					   $after_fina_day= date('Y-m-d',strtotime(date("Y-m-d", strtotime($todate)) . "+$alert_finance day"));
					   $count=1;
					   
					   $str="next_payment_date between '$todate' AND '$after_fina_day' AND payment_status='Unpaid'";
					   $num=$dbf->countRows('installment_details',$str);
					   foreach($dbf->fetchOrder("installment_details",$str,"","") as $val_inst) {
					   $veh_info=$dbf->fetchSingle("new_vehicle_registration","id='$val_inst[vehi_id]'");
					   //Vehicle Type : Crane , Truck
						$veh_type=$dbf->fetchSingle("vehicle_types","id='$val_inst[vehi_id]'"); 
					   ?>
                      <tr>
                        <td height="25" align="center"><?php echo $count; ?></td>
                        <td style="padding-left:5px;"><?php echo $veh_info[vehicle_no]; ?></td>
                        <td style="padding-left:5px;"><?php echo $veh_type[vtype]; ?></td>
                        <td style="padding-left:5px;">Rs. <?php echo $veh_info[installment_per_month]; ?></td>
                        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_inst[next_payment_date])); ?></td>
                        <td style="padding-left:5px;"><?php echo $veh_info[finance_by]; ?></td>
                        <td style="padding-left:5px;"><?php echo $veh_info[payment_bank]; ?></td>
                        <td style="padding-left:5px;"><?php echo $veh_info[loan_ac_no]; ?></td>
                        <td style="padding-left:5px;"><?php echo $veh_info[farm_name]; ?></td>
                        <td align="center">
                         <a href="vehicle_details.php?id=<?php echo $veh_info[id];?>" class="linktext"><img src="images/view.png" width="18" height="18" title="Update Payment"></a>
                        </td>
                      </tr>
                      <?php $count+=1;} ?>
                       <?php if($num==0) { ?>
                      <tr>
                        <td height="25" colspan="10" align="center" class="error">No Finance Reminder Available.</td>
                        </tr>
                       <?php } ?>
                    </table>

                    </td>
                    <td>&nbsp;</td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td class="white_heading">Other Reminders</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="10">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="14">&nbsp;</td>
                  </tr>
				  
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center">
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                      <tr bgcolor="#999999" class="text1">
                        <td width="6%" align="center">Sl. No.</td>
                        <td width="23%" height="30" style="padding-left:5px;">Alert Type</td>
                        <td width="20%" height="30" style="padding-left:5px;">Vehicle No.</td>
                        <td width="25%" height="30" style="padding-left:5px;">Expire Date</td>
                        <td width="15%" height="30" style="padding-left:5px;">Amount</td>
                        <td width="11%" align="center">Action</td>
                      </tr>
                       <?php
					   $other_rem_day=$dbf->fetchSingle("admin","id='1'");
					   $alert_other=$other_rem_day[alert_other]; 
					   $cur_date=date("Y-m-d");
					   $after_day= date('Y-m-d',strtotime(date("Y-m-d", strtotime($cur_date)) . "+$alert_other day"));
					   $count=1;
					   $rem_str="end_date between '$cur_date' AND '$after_day'";
					   $rem_num=$dbf->countRows('other_reminders',$rem_str);
					   
					   foreach($dbf->fetchOrder("other_reminders",$rem_str,"","") as $val_rem) {
					   ?>
                      <tr>
                        <td height="25" align="center"><?php echo $count; ?></td>
                        <td style="padding-left:5px;"><?php echo $val_rem[alert_type]; ?></td>
                        <td style="padding-left:5px;"><?php echo $val_rem[vehicle_no]; ?></td>
                        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_rem[end_date])); ?></td>
                        <td style="padding-left:5px;">Rs. <?php echo $val_rem[amount]; ?></td>
                        <td align="center">
                          <a href="manage_other_reminder.php" class="linktext"><img src="images/view.png" width="18" height="18" title="Update Payment"></a>
                        </td>
                      </tr>
                      <?php $count+=1;} ?>
                       <?php if($rem_num==0) { ?>
                      <tr>
                        <td height="25" colspan="6" align="center" class="error">No Other Reminder Available.</td>
                        </tr>
                       <?php } ?>
                    </table>
                    </td>
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
