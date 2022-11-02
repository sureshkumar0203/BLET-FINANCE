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


if(isset($_POST[submit])<>'')
{
	$num=$db->countRows('new_vehicle_registration',"vehicle_no='$_POST[vehicle_no]'");
	if($num>0)
	{
		header("Location:add_new_vehicles.php?msg=exist");
	}
	else
	{
		//insert to new_vehicle_registration table
		$vehicle_no=strtoupper($_POST[vehicle_no]);
		$finance_by=strtoupper($_POST[finance_by]);
		$payment_bank=strtoupper($_POST[payment_bank]);
		$farm_name=strtoupper($_POST[farm_name]);
		
		
		$string="vehicle_no='$vehicle_no',vtype='$_POST[vtype]',installment_per_month='$_POST[installment_per_month]',loan_start_date='$_POST[loan_start_date]',loan_end_date='$_POST[loan_end_date]',finance_amount='$_POST[finance_amount]',interest_amount='$_POST[interest_amount]',total_amount_paid_to_bank='$_POST[total_amount_paid_to_bank]',no_of_installment='$_POST[no_of_installment]',rate_of_interest='$_POST[rate_of_interest]',finance_by='$finance_by',payment_bank='$payment_bank',loan_ac_no='$_POST[loan_ac_no]',farm_name='$farm_name',alert_finance='$_POST[alert_finance]'";
		 
		 $ins_id=$db->insertSet("new_vehicle_registration",$string);
		 
		 $todate=$_POST[loan_start_date];

		for($i=1;$i<=$_POST[no_of_installment];$i++)
		{
			if($i==1)
			{
				$next_payment_date=$_POST[loan_start_date];
			}
			else
			{
				$next_payment_date = date('Y-m-d',strtotime(date("Y-m-d", strtotime($next_payment_date)) . "+1 month"));
			}
			$string="vehi_id='$ins_id',vehi_no='$_POST[vehicle_no]',next_payment_date='$next_payment_date',payment_status='Unpaid'";
			$db->insertSet("installment_details",$string);
		}
		//echo $string."<br>";
		//exit;
		header("Location:add_new_vehicles.php?msg=added");
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
        <td width="1314" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="3" align="left" valign="top"></td>
            </tr>
          <tr>
            <td width="226" align="left" valign="top" height="365"><?php include 'left.php';?></td>
            <td width="10">&nbsp;</td>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle" style="padding-left:10px;"><h2>Add New Vehicle</h2></td>
                          <td width="50%" align="right" valign="middle"></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#e2e2e2" height="320">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="righttableborder2">
                  <tr>
                    <td height="30" align="left" valign="middle" bgcolor="#e2e2e2" style="padding-left:20px;">
                    <?php if($_REQUEST[msg]=='added'){ ?>
                      <span class="success">Record has been added  successfully. </span>
                    <?php } ?>
                    
                    <?php if($_REQUEST[msg]=='exist'){ ?>
                      <span class="noRecords2">This Vehicle No. Already Exist. </span>
                    <?php } ?>
                    
                      </td>
                  </tr>
                  <tr>
                    <td bgcolor="#e2e2e2" valign="top" style="padding-left:20px;">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					    <tr>
					      <td width="17%" height="40" align="left" valign="middle">Vehicle No<span class="startext">*</span> :<br>
						  <span class="level_msg">(ex. OR02BA6551) </span></td>
					      <td width="19%" height="40" align="left" valign="middle">
                          <input name="vehicle_no" type="text" class="validate[required] textfield121" id="vehicle_no" autocomplete="off" style="text-transform:uppercase;"/></td>
					      <td width="4%" height="40" align="left" valign="middle">&nbsp;</td>
					      <td width="12%" height="40" align="left" valign="middle">Total amount paid to bank <span class="startext">*</span> : </td>
					      <td width="48%" height="40" align="left" valign="middle">
                          <input name="total_amount_paid_to_bank" type="text" class="validate[required] textfield121" id="total_amount_paid_to_bank" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Vehicle Type <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <select name="vtype" class="validate[required]" id="vtype" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('vehicle_types',"","vtype","","") as $val) { ?>
                            <option value="<?php echo $val[id]; ?>"><?php echo $val[vtype]; ?></option>
                             <?php } ?>
                          </select>
                          </td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">No. of installment <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="no_of_installment" type="text" class="validate[required] textfield121" id="no_of_installment" autocomplete="off" onKeyPress="return onlyNumbers(event);"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Installment amount / month <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="installment_per_month" type="text" class="validate[required] textfield121" id="installment_per_month" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Rate of interest <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="rate_of_interest" type="text" class="validate[required] textfield121" id="rate_of_interest" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">
                          Loan start date<span class="startext">*</span> :<br>
						  <span class="level_msg">(ex. Y-M-D) </span>
                          </td>
					      <td height="40" align="left" valign="middle">
                          <input name="loan_start_date" type="text" class="datepick validate[required] textfield121" id="loan_start_date" autocomplete="off" readonly/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Finance By <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="finance_by" type="text" class="validate[required] textfield121" id="finance_by" autocomplete="off" style="text-transform:uppercase;"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">
                          Loan end date <span class="startext">*</span> :<br>
						  <span class="level_msg">(ex. Y-M-D) </span>
                          </td>
					      <td height="40" align="left" valign="middle">
                          <input name="loan_end_date" type="text" class="datepick validate[required] textfield121" id="loan_end_date" autocomplete="off" readonly/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Payment Bank<span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="payment_bank" type="text" class="validate[required] textfield121" id="payment_bank" autocomplete="off" style="text-transform:uppercase;"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Finance amount <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="finance_amount" type="text" class="validate[required] textfield121" id="finance_amount" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Loan A/C No. <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="loan_ac_no" type="text" class="validate[required] textfield121" id="loan_ac_no" autocomplete="off"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Interest amount <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="interest_amount" type="text" class="validate[required] textfield121" id="interest_amount" autocomplete="off" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Farm Name <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="farm_name" type="text" class="validate[required] textfield121" id="farm_name" autocomplete="off" style="text-transform:uppercase;"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">
                          Alert Day <span class="startext">*</span> :
                          </td>
					      <td height="40" align="left" valign="middle">
                    <input name="alert_finance" type="text" class="validate[required] textfield121" id="alert_finance" autocomplete="off" onKeyPress="return onlyNumbers(event);"/>
                          </td>
					      </tr>
					    <tr>
					      <td height="40" colspan="5" align="left" valign="middle">
                          <input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;
                           <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_new_vehicles.php'">
                          </td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
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
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="5" align="left" valign="top"><img src="images/bottom-left-box-bg.jpg" alt="bot_left_bg" width="5" height="5" /></td>
                      <td height="5" class="botmidboxbg"></td>
                      <td width="5"><img src="images/bot-right-box-bg.jpg" alt="bot_right" width="5" height="5" /></td>
                    </tr>
                </table></td>
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
