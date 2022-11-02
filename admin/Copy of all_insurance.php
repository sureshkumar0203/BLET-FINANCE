<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
$pageTitle='Admin Panel';
include 'application_top.php';
//Object initialization
$dbf = new User();

if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}


/*Get the vehicle no , vehicle type*/
$veh_info=$dbf->fetchSingle("vehicle_registration","id='$_REQUEST[id]'");

$veh_typ=$dbf->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");	

if($_REQUEST[action]=="delete")
{
	$num=$dbf->countRows('installment_details',"vehi_id='$_REQUEST[vid]' AND payment_status='Paid'");
	if($num==0)
	{
		$dbf->deleteFromTable("finance_details","vehicle_id='$_REQUEST[vid]'");
		$dbf->deleteFromTable("fitness_details","vehicle_id='$_REQUEST[vid]'");
		$dbf->deleteFromTable("installment_details","vehi_id='$_REQUEST[vid]'");
		$dbf->deleteFromTable("insurance_details","vehicle_id='$_REQUEST[vid]'");
		$dbf->deleteFromTable("permit_details","vehicle_id='$_REQUEST[vid]'");
		$dbf->deleteFromTable("roadtax_details","vehicle_id='$_REQUEST[vid]'");
		$dbf->deleteFromTable("vehicle_registration","id='$_REQUEST[vid]'");
		header("Location:manage_new_vehicles.php?msg=deleted");
	}
	else
	{
		header("Location:manage_new_vehicles.php?msg=no");
		exit;
	}
}

//Vehicle Finance

if($_REQUEST[hid_action]==1)
{
	$no_of_installment=$dbf->GetNoofMonths_In2dates($_POST[loan_start_date],$_POST[loan_end_date]);
	$finance_by=strtoupper($_POST[finance_by]);
	$payment_bank=strtoupper($_POST[payment_bank]);
	$farm_name=strtoupper($_POST[farm_name]);
		
	$num=$dbf->countRows('finance_details',"vehicle_id='$_REQUEST[vid]' AND loan_end_date='$_POST[loan_end_date]'");
	
	if($num>0)
	{
		header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=exist");
		exit;
	}
	else
	{
		$string="vehicle_id='$_POST[vid]',installment_per_month='$_POST[installment_per_month]',loan_start_date='$_POST[loan_start_date]',loan_end_date='$_POST[loan_end_date]',finance_amount='$_POST[finance_amount]',interest_amount='$_POST[interest_amount]',total_amount_paid_to_bank='$_POST[total_amount_paid_to_bank]',no_of_installment='$no_of_installment',rate_of_interest='$_POST[rate_of_interest]',finance_by='$finance_by',payment_bank='$payment_bank',loan_ac_no='$_POST[loan_ac_no]',farm_name='$farm_name',alert_finance='$_POST[alert_finance]'";
		 $ins_id=$dbf->insertSet("finance_details",$string);
		 
		 $todate=$_POST[loan_start_date];
		 
		for($i=0;$i<=$no_of_installment;$i++)
		{
			if($i==0)
			{
				$next_payment_date=$_POST[loan_start_date];
			}
			else
			{
				$next_payment_date = date('Y-m-d',strtotime(date("Y-m-d", strtotime($next_payment_date)) . "+1 month"));
			}
			$string="vehi_id='$_POST[vid]',next_payment_date='$next_payment_date',payment_status='Unpaid',finance_id='$ins_id'";
			$dbf->insertSet("installment_details",$string);
		}
		header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=added");
		exit;
	}
}

if($_REQUEST[hid_action]=="updatePeriod")
{
	$finance_by=strtoupper($_POST[finance_by]);
	$payment_bank=strtoupper($_POST[payment_bank]);
	$farm_name=strtoupper($_POST[farm_name]);
	
	$string="installment_per_month='$_POST[installment_per_month]',finance_amount='$_POST[finance_amount]',interest_amount='$_POST[interest_amount]',total_amount_paid_to_bank='$_POST[total_amount_paid_to_bank]',rate_of_interest='$_POST[rate_of_interest]',finance_by='$finance_by',payment_bank='$payment_bank',loan_ac_no='$_POST[loan_ac_no]',farm_name='$farm_name',alert_finance='$_POST[alert_finance]'";
	$dbf->updateTable("finance_details",$string,"id='$_REQUEST[edit_id]'");
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=updated");
	exit;
}


//Vehicle insurance
if($_REQUEST[hid_action]==2)
{
	$policy_no=addslashes($_POST[policy_no]);
	$pre_policy_no=addslashes($_POST[pre_policy_no]);
	$insured_name=strtoupper($_POST[insured_name]);
	$issuing_address=strtoupper($_POST[issuing_address]);
	
	if($_FILES['file']['name']!="")
	{
	  $file =time().".".substr(strrchr($_FILES['file']['name'], "."), 1);								
	  if($file!='')
	  {
		  copy($_FILES['file'][tmp_name],"insurance_docs/".$file);
	  }
	}
	
	$string="vehicle_id='$_POST[vid]',policy_type='$_POST[policy_type]',policy_no='$policy_no',pre_policy_no='$pre_policy_no',insured_name='$insured_name',issuing_address='$issuing_address',insurance_company_name='$_POST[insurance_company_name]',insurance_from_dt='$_POST[insurance_from_dt]',insurance_to_dt='$_POST[insurance_to_dt]',gross_premium='$_POST[gross_premium]',service_tax='$_POST[service_tax]',stamp_duty='$_POST[stamp_duty]',total='$_POST[total]',alert_insurance='$_POST[alert_insurance]',insurance_type='Insurance',file_name='$file',date_of_payment='$_REQUEST[date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$_REQUEST[cheque_no]'";
	$dbf->insertSet("insurance_details",$string);
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=added");
	exit;
}

if($_REQUEST[edit_insurance]=="update")
{
	$policy_type=addslashes($_POST[policy_type]);
	$policy_no=addslashes($_POST[policy_no]);
	$insured_name=strtoupper($_POST[insured_name]);
	$issuing_address=strtoupper($_POST[issuing_address]);
	
	if($_REQUEST[mode_of_payment]=="Cash")
	{
		$cheque_no="";
	}
	else
	{
		$cheque_no=$_REQUEST[cheque_no];
	}
							
	
	if($_FILES['file']['name']!='')
	{
		$file =time().".".substr(strrchr($_FILES['file']['name'], "."), 1);		
		
		$res_ins=$dbf->fetchSingle("insurance_details","id='$_REQUEST[edit_id]'"); 
		$path1="insurance_docs/".$res_ins[file_name];
		unlink($path1);
	
		copy($_FILES['file'][tmp_name],"insurance_docs/".$file);
		$string="policy_type='$policy_type',policy_no='$_POST[policy_no]',insured_name='$insured_name',issuing_address='$issuing_address',insurance_company_name='$_POST[insurance_company_name]',insurance_from_dt='$_POST[insurance_from_dt]',insurance_to_dt='$_POST[insurance_to_dt]',gross_premium='$_POST[gross_premium]',service_tax='$_POST[service_tax]',stamp_duty='$_POST[stamp_duty]',total='$_POST[total]',alert_insurance='$_POST[alert_insurance]',insurance_type='Insurance',file_name='$file',date_of_payment='$_REQUEST[date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$cheque_no'";
	$dbf->updateTable("insurance_details",$string,"id='$_REQUEST[edit_id]'");
	}
	else
	{
		$string="policy_type='$policy_type',policy_no='$_POST[policy_no]',insured_name='$insured_name',issuing_address='$issuing_address',insurance_company_name='$_POST[insurance_company_name]',insurance_from_dt='$_POST[insurance_from_dt]',insurance_to_dt='$_POST[insurance_to_dt]',gross_premium='$_POST[gross_premium]',service_tax='$_POST[service_tax]',stamp_duty='$_POST[stamp_duty]',total='$_POST[total]',alert_insurance='$_POST[alert_insurance]',insurance_type='Insurance',date_of_payment='$_REQUEST[date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$cheque_no'";
	$dbf->updateTable("insurance_details",$string,"id='$_REQUEST[edit_id]'");
	}
	
	
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=updated");
	exit;
	
}


//Vehicle Road Tax
if($_REQUEST[hid_action]==3)
{
	$owner_name=strtoupper($_POST[owner_name]);
	$book_sl_no=strtoupper($_POST[book_sl_no]);
	
	$string="vehicle_id='$_POST[vid]',owner_name='$owner_name',book_sl_no='$book_sl_no',issuing_officer='$_POST[issuing_officer]',issuing_date='$_POST[issuing_date]',tax_from_dt='$_POST[tax_from_dt]',tax_to_dt='$_POST[tax_to_dt]',tax_amount='$_POST[tax_amount]',fine='$_POST[fine]',total='$_POST[total]',other_expence='$_POST[other_expence]',alert_tax='$_POST[alert_tax]',date_of_payment='$_REQUEST[rt_date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$_REQUEST[cheque_no]'";
	$dbf->insertSet("roadtax_details",$string);
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=added");
	exit;
}

if($_REQUEST[edit_tax]=="update")
{
	$owner_name=strtoupper($_POST[owner_name]);
	$book_sl_no=strtoupper($_POST[book_sl_no]);
	
	if($_REQUEST[mode_of_payment]=="Cash")
	{
		$cheque_no="";
	}
	else
	{
		$cheque_no=$_REQUEST[cheque_no];
	}
	
	$string="owner_name='$owner_name',book_sl_no='$book_sl_no',issuing_officer='$_POST[issuing_officer]',issuing_date='$_POST[issuing_date]',tax_from_dt='$_POST[tax_from_dt]',tax_to_dt='$_POST[tax_to_dt]',tax_amount='$_POST[tax_amount]',fine='$_POST[fine]',total='$_POST[total]',other_expence='$_POST[other_expence]',alert_tax='$_POST[alert_tax]',date_of_payment='$_REQUEST[rt_date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$cheque_no'";
	$dbf->updateTable("roadtax_details",$string,"id='$_REQUEST[edit_id]'");
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=updated");
	exit;
	
}


//Vehicle Fitness
if($_REQUEST[hid_action]==4)
{
	$certificate_no=strtoupper($_POST[certificate_no]);
	$issuing_officer=strtoupper($_POST[issuing_officer]);
	
	$string="vehicle_id='$_POST[vid]',certificate_no='$certificate_no',certificate_date='$_POST[certificate_date]',issuing_officer='$issuing_officer',fitness_from_dt='$_POST[fitness_from_dt]',fitness_to_dt='$_POST[fitness_to_dt]',rto_office='$_POST[rto_office]',fitness_amount='$_POST[fitness_amount]',other_expence='$_POST[other_expence]',alert_fitness='$_POST[alert_fitness]',date_of_payment='$_REQUEST[fitness_date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$_REQUEST[cheque_no]'";
	$dbf->insertSet("fitness_details",$string);
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=added");
	exit;
}

if($_REQUEST[edit_fitness]=="update")
{
	$certificate_no=strtoupper($_POST[certificate_no]);
	$issuing_officer=strtoupper($_POST[issuing_officer]);
	if($_REQUEST[mode_of_payment]=="Cash")
	{
		$cheque_no="";
	}
	else
	{
		$cheque_no=$_REQUEST[cheque_no];
	}
	$string="certificate_no='$certificate_no',certificate_date='$_POST[certificate_date]',issuing_officer='$issuing_officer',fitness_from_dt='$_POST[fitness_from_dt]',fitness_to_dt='$_POST[fitness_to_dt]',rto_office='$_POST[rto_office]',fitness_amount='$_POST[fitness_amount]',other_expence='$_POST[other_expence]',alert_fitness='$_POST[alert_fitness]',date_of_payment='$_REQUEST[fitness_date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$cheque_no'";
	$dbf->updateTable("fitness_details",$string,"id='$_REQUEST[edit_id]'");
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=updated");
	exit;
	
}


//Vehicle Permit
if($_REQUEST[hid_action]==5)
{
	$permit_no=strtoupper($_POST[permit_no]);
	$name_of_holder=strtoupper($_POST[name_of_holder]);
	
	$string="vehicle_id='$_POST[vid]',permit_no='$permit_no',issue_date='$_POST[issue_date]',name_of_holder='$name_of_holder',rto_office='$_POST[rto_office]',permit_from_dt='$_POST[permit_from_dt]',permit_to_dt='$_POST[permit_to_dt]',permit_amount='$_POST[permit_amount]',alert_permit='$_POST[alert_permit]',date_of_payment='$_REQUEST[permit_date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$_REQUEST[cheque_no]'";
	$dbf->insertSet("permit_details",$string);
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=added");
	exit;
}

if($_REQUEST[edit_permit]=="update")
{
	$permit_no=strtoupper($_POST[permit_no]);
	$name_of_holder=strtoupper($_POST[name_of_holder]);
	if($_REQUEST[mode_of_payment]=="Cash")
	{
		$cheque_no="";
	}
	else
	{
		$cheque_no=$_REQUEST[cheque_no];
	}
	$string="permit_no='$permit_no',issue_date='$_POST[issue_date]',name_of_holder='$name_of_holder',rto_office='$_POST[rto_office]',permit_from_dt='$_POST[permit_from_dt]',permit_to_dt='$_POST[permit_to_dt]',permit_amount='$_POST[permit_amount]',alert_permit='$_POST[alert_permit]',date_of_payment='$_REQUEST[permit_date_of_payment]',mode_of_payment='$_REQUEST[mode_of_payment]',cheque_no='$cheque_no'";
	$dbf->updateTable("permit_details",$string,"id='$_REQUEST[edit_id]'");
	header("Location:add_all_other_info.php?id=$_REQUEST[vid]&msg=updated");
	exit;
	
}



?>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	$(function() {

		$( "#tabs" ).tabs({
			cookie: {
				// store cookie for a week, without, it would be a session cookie
				expires: 7
			}
		});
		
		var $tabs = $("#tabs").tabs();
		$('#mylink').click(function() { // bind click event to link
    $tabs.tabs('select', 2); // switch to third tab
    return false;
	
	
});


	$('#mylink2').click(function() { // bind click event to link
    $tabs.tabs('select', 4); // switch to third tab
    return false;
	
	
	
});

	});

function updatePayment(installment_id,vid)
{
	//alert(cart_id);
	var payment_status=$('#payment_status'+installment_id).val();
	var paid_date=$('#paid_date'+installment_id).val();
	var remark=$('#remark'+installment_id).val();
	window.location.href="update_payment.php?action=update&installment_id="+installment_id+"&payment_status="+payment_status+"&paid_date="+paid_date+"&remark="+remark+"&vid="+vid;
}

</script>	
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Manage all Insurance</h2></td>
                          <td width="50%" align="right" valign="middle"><h2>&nbsp;</h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#e2e2e2" height="320" id="show-tab">
                <div class="demo pageContainer">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">LIC</a></li>
                        <li><a href="#tabs-2"> Health Insurance </a></li>
                    </ul>
                    <div id="tabs-1">
                    <?php include("manage_lic.php"); ?>
                    </div>
                    
                    <div id="tabs-2">
                    <?php include("vehicle_insurance.php"); ?>
                    </div>
                </div>
                </div>
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
