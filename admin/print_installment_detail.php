<?php 
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Vehicle Detail Information';
include 'application_top.php';
//Object initialization
//$db = new User();

if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}

$veh_info=$db->fetchSingle("new_vehicle_registration","id='$_REQUEST[id]'");
$veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vtype]'");
$no_of_installment_remaining=$db->countRows('installment_details',"vehi_id=$veh_info[id] AND payment_status='Unpaid'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installment Details</title>
<style type="text/css">
<!--
.style3 {
	font-family: Algerian;
	color: #E8E8E8;
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="background: url(images/top_bg.jpg) repeat-x;">
  <tr>
 
    <td width="50%" height="90" align="left" valign="middle" style="padding-left:23px;">
    <h1><a href="admin_home.php" class="style3" style="text-decoraon:none;">BLE FINANCE </a></h1></td>
    <td width="50%" align="right" valign="top" style="padding-right:5px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="middle" class="greenborder" >&nbsp;</td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="20%" align="left" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="10" class="text1" style="padding-left:10px;"></td>
        <td height="10" align="center" valign="middle" class="text1"></td>
        <td height="10"></td>
      </tr>
      <tr>
        <td width="43%" height="25" class="text1" style="padding-left:10px;">Vehicle No.</td>
        <td width="9%" align="center" valign="middle" class="text1">:</td>
        <td width="48%" height="25"><?php echo $veh_info[vehicle_no]; ?></td>
      </tr>
      <tr>
        <td height="25" class="text1" style="padding-left:10px;">Vehicle type</td>
        <td align="center" valign="middle" class="text1">:</td>
        <td height="25"><?php echo $veh_type[vtype]; ?></td>
      </tr>
      
        <tr>
        <td height="25" colspan="3" class="text1" style="padding-left:10px;">
        No. of installment <br />
        remaining : <font color="#009900"><?php echo $no_of_installment_remaining; ?></font></td>
        </tr>
      
        <tr>
        <td height="25" class="text1" style="padding-left:10px;">&nbsp;</td>
        <td align="center" valign="middle" class="text1">&nbsp;</td>
        <td height="25">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" class="text1" style="padding-left:10px;"></td>
        <td height="10" align="center" valign="middle" class="text1"></td>
        <td height="10"></td>
      </tr>
    </table>
      </td>
      <td width="30%" style="padding-left:10px; padding-right:10px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
      <td height="25" class="text1" style="padding-left:10px;">Total amount <br />
paid to bank</td>
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
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        <td height="25" colspan="3" class="text1" style="padding-left:10px;">
        Loan A/C No. :&nbsp; <span class="text25"><?php echo $veh_info[loan_ac_no]; ?> </span>
        </td>
        </tr>
      <tr>
        <td height="25" class="text1" style="padding-left:10px;">Installment amount / Month</td>
        <td align="center" valign="middle" class="text1">:</td>
        <td height="25">Rs. <?php echo $veh_info[installment_per_month]; ?></td>
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
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        <td height="25" class="text1"><font color="#FF0000"><?php echo $veh_info[no_of_installment]; ?></font></td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
          <table height="61" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"   width="100%">
          <thead>
            <tr>
              <th width="9%" height="27" align="center" valign="middle" class="fetch_headers">SL. No.</th>
             
              <th width="15%" align="left" valign="middle" class="fetch_headers">Payment Due Date</th>
              <th width="15%" align="left" valign="middle" class="fetch_headers">Payment Paid Date</th>
              <th width="14%" align="left" valign="middle" class="fetch_headers">Installment Amount</th>
              <th width="13%" align="left" valign="middle" class="fetch_headers">Payment Status</th>
               <th width="40%" align="left" valign="middle" class="fetch_headers">Remark</th>
              </tr>
          </thead>
          <tbody>
           <?php
           $count=1;
           $str="vehi_id='$veh_info[id]'";
           $num=$db->countRows('installment_details',$str);
           foreach($db->fetchOrder("installment_details",$str,"","") as $val_inst) { 
           ?>
            <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
              <td height="30" align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst[id];?>">
              <?php echo $count; ?>
              </td>
              
              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_inst[next_payment_date])); ?></td>
              <td align="left" class="fetch_contents" style="padding-left:3px;">
               <?php if($val_inst[payment_status]=="Paid") { ?>
			  <?php echo date("jS M,Y",strtotime($val_inst[paid_date])); ?>
              <?php } else { ?>
              ---
              <?php } ?>
              </td>
              <td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo $veh_info[installment_per_month]; ?></td>
              <td align="left" class="fetch_contents" style="padding-left:3px;">
              <?php if($val_inst[payment_status]=="Paid") { ?>
              <font color="#009900"><?php echo $val_inst[payment_status]; ?></font> <?php } else { ?>
              <font color="#FF0000"><?php echo $val_inst[payment_status]; ?></font> <?php } ?>
             
              </td>
              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $val_inst[remark]; ?></td>
            </tr>
            <?php $count+=1;} ?>
          </tbody>
          </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
<script type="text/javascript">

window.print();

</script>