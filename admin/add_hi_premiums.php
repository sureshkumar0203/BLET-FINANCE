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

$med_reg=$db->fetchSingle("mediclaim_registration","id='$_REQUEST[id]'"); 

if(isset($_REQUEST["add_premium"])=="add")
{
	//insert hi_premium_payment_details table
	$string="policy_id='$_REQUEST[id]',total_premium_amount='$_POST[total_premium_amount]',payment_date='$_POST[payment_date]',next_payment_date='$_POST[next_payment_date]',alert_med='$_POST[alert_med]'";
	$db->insertSet("hi_premium_payment_details",$string);
	header("Location:add_hi_premiums.php?id=$_REQUEST[id]&msg=added");

}

if(isset($_REQUEST["edit_hi_premium"])=="update")
{
	$string="policy_id='$_REQUEST[id]',total_premium_amount='$_POST[total_premium_amount]',payment_date='$_POST[payment_date]',next_payment_date='$_POST[next_payment_date]',alert_med='$_POST[alert_med]'";
	$db->updateTable("hi_premium_payment_details",$string,"id='$_REQUEST[edit_id]'");
	header("Location:add_hi_premiums.php?id=$_REQUEST[policy_id]&msg=updated");

}

?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function editMedPremium(eid){
	var url="edit_hi_premium.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show").html(res);
	});
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Add Premium </h2></td>
                          <td width="50%" align="right" valign="middle">
                          <a href="manage_mediclaim.php"><img src="images/cancel_btn1.jpg" border="0"/></a>
                          </td>
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
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;">
                      <tr>
                        <td width="37%" height="25" class="text25">Policy Details</td>
                        <td width="37%" class="text25">Personal Details</td>
                        <td width="26%" class="text25">&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top">
                        <?php echo strtoupper($med_reg["policy_no"]); ?><br />
                        <span class="text1">ID Card No. : </span> <?php echo strtoupper($med_reg["idcard_no"]); ?><br />
                        <span class="text1">Sum Assured : </span> Rs. <?php echo $med_reg["sum_assured"]; ?> <br />
                        <span class="text1">Premium : </span> Rs. <?php echo $med_reg["premium"]; ?> <br />
                        <span class="text1">Discount : </span> Rs. <?php echo $med_reg["discount"]; ?> <br />
                        <span class="text1">Net Premium  : </span> Rs. <?php echo $med_reg["net_premium"]; ?> <br />
                        <span class="text1">Service Tax  : </span> Rs. <?php echo $med_reg["service_tax"]; ?> <br />
                        <span class="text1">Hospital Allowance  : </span>Rs. <?php echo $med_reg["hospital_allowance"]; ?> <br />
                        <span class="text1">Total  : </span>Rs. <?php echo $med_reg["total"]; ?> <br />
                        <span class="text1">Tax Benefit  : </span> Rs. <?php echo $med_reg["tax_benefit"]; ?> <br />
                        </td>
                        <td valign="top">
						<span class="text1">Policy Holder Name :</span> <?php echo strtoupper($med_reg["policy_holder_name"]); ?><br />
                        <span class="text1">Relation :</span> <?php echo strtoupper($med_reg["relation"]); ?><br />
                        <span class="text1">DOB :</span> <?php echo date("jS M,Y",strtotime($med_reg["dob"])); ?><br />
                        <span class="text1">Age :</span> <?php echo $med_reg["age"]; ?>
                        </td>
                        <td valign="top">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td >&nbsp;</td>
                  </tr>
                  <tr>
                    <td id="td_show">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                    <input name="add_premium" type="hidden" value="add">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;">
                    <tr>
                      <td width="16%" class="text1">Total Premium Amount</td>
                      <td width="16%" class="text1">Payment Date</td>
                      <td width="16%" class="text1">Next Premium Date</td>
                      <td width="16%" class="text1">Alert Day </td>
                      <td width="40%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>
                      <input name="total_premium_amount" type="text" class="validate[required] textfield121" id="total_premium_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $med_reg["total"]; ?>"/>
                      </td>
                      <td><input name="payment_date" type="text" class="datepick validate[required] textfield121" id="payment_date" autocomplete="off" readonly/> </td>
                      <td>
                      <input name="next_payment_date" type="text" class="datepick validate[required] textfield121" id="next_payment_date" autocomplete="off" value="" readonly/>                      </td>
                      <td><input name="alert_med" type="text" class="validate[required] textfield121" id="alert_med" onKeyPress="return onlyNumbers(event);"/></td>
                      <td><input name="submit" type="submit" class="button" id="submit" value="Submit"></td>
                    </tr>
                  </table>
                    </form>
                    </td>
                  </tr>
                  
                   <tr>
                     <td >&nbsp;</td>
                   </tr>
                   <tr>
                     <td height="200" align="left" valign="top">
                    <table height="61" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC" class="tablesorter" id="sort_table" width="100%" style="margin-left:10px;">
                      <thead>
                      <tr>
                      <th width="5%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                      
                      <th width="36%" align="left" valign="middle" class="fetch_headers">Total Premium Amount</th>
                      <th width="18%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
                      <th width="17%" align="left" valign="middle" class="fetch_headers">Next Payment Date</th>
                      <th width="12%" align="center" valign="middle" class="fetch_headers">Alert day</th>
                      <th colspan="5" align="center" valign="middle" class="fetch_headers">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $count=1;
                      $str="policy_id='$_REQUEST[id]'";
                      $num=$db->countRows('hi_premium_payment_details',$str);
                      foreach($db->fetchOrder("hi_premium_payment_details",$str,"","") as $val_hi_premium) { 
                      ?>
                      <?php if($num!=0) { ?>
                      <tr>
                      <td height="30" align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $count; ?>
                      </td>
                      
                      <td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo number_format($val_hi_premium["total_premium_amount"],2); ?></td>
                      
                      <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_hi_premium["payment_date"])); ?></td>
                      <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_hi_premium["next_payment_date"])); ?></td>
                      <td align="center" class="fetch_contents"><?php echo $val_hi_premium["alert_med"]; ?></td>
                      <td width="12%" align="center" class="fetch_contents">
                      <a href="javascript:void(0);" onClick="editMedPremium(<?php echo $val_hi_premium["id"];?>);">Edit</a>
                      </td>
                      </tr>
                      <?php } ?>
                      <?php $count+=1;} ?>
                      <?php if($num==0) { ?>
                      <tr>
                      <td height="30" colspan="6" align="center" class="startext"><font color="#FF0000">No Records found.</font></td>
                      </tr>
                      <?php } ?>
                      </tbody>
                      </table>
                     </td>
                   </tr>
                   <tr>
                    <td>&nbsp;</td>
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
