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

$lic_reg=$db->fetchSingle("lic_registration","id='$_REQUEST[id]'"); 

if(isset($_REQUEST["add_premium"])=="add"){
	//print_r($_REQUEST);exit;
	//insert premium_payment_details table
	 // $string="policy_id='$_REQUEST[id]',premium_amount='$_REQUEST[premium_amount]',premium_mode='$_REQUEST[premium_mode]',payment_date='$_REQUEST[payment_date]',next_payment_date='$_REQUEST[next_payment_date]',alert_lic='$_REQUEST[alert_lic]',pmode='$_REQUEST[mode_of_payment]',bankname='$_REQUEST[bankname]',ddno='$_REQUEST[ddno]'";
   $string="policy_id='$_REQUEST[id]',premium_amount='$_REQUEST[premium_amount]',premium_mode='$_REQUEST[premium_mode]',payment_date='$_REQUEST[payment_date]',next_payment_date='$_REQUEST[next_payment_date]',alert_lic='$_REQUEST[alert_lic]'";
	
	$db->insertSet("premium_payment_details",$string);
	header("Location:add_premiums.php?id=$_REQUEST[id]&msg=added");

}

if(isset($_REQUEST["edit_premium"])=="update"){
	$string="policy_id='$_REQUEST[id]',premium_amount='$_POST[premium_amount]',premium_mode='$_REQUEST[premium_mode]',payment_date='$_POST[payment_date]',next_payment_date='$_POST[next_payment_date]',alert_lic='$_POST[alert_lic]',pmode='$_REQUEST[mode_of_payment]',bankname='$_REQUEST[bankname]',ddno='$_REQUEST[ddno]'";
	
	$db->updateTable("premium_payment_details",$string,"id='$_REQUEST[edit_id]'");
	header("Location:add_premiums.php?id=$_REQUEST[policy_id]&msg=updated");

}
if(isset($_REQUEST["action"]) == "disapprove"){
	
	$db->updateTable("premium_payment_details", "status='0'", "id='$_REQUEST[record_id]'");
	header("Location:add_premiums.php?id=$_REQUEST[id]");
	exit;
}
if(isset($_REQUEST["action"]) == "approve"){
	
	$db->updateTable("premium_payment_details", "status='1'", "id='$_REQUEST[record_id]'");
	header("Location:add_premiums.php?id=$_REQUEST[id]");
	exit;
}
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function editLicPremium(eid){
	var url="edit_premium.php";	
	$.post(url,{"eid":eid},function(res){ 
		$("#td_show").html(res);
	});
}
function showHide(mode){
	if(mode=="Cheque"){
		document.getElementById('tr_id').style.display='';
	}
	if(mode=="Draft"){
		document.getElementById('tr_id').style.display='';
	}	
	if(mode=="Cash"){
		document.getElementById('tr_id').style.display='none';
	}
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Edit LIC Details</h2></td>
                          <td width="50%" align="right" valign="middle">
                          <a href="manage_lic.php"><img src="images/cancel_btn1.jpg" border="0"/></a>
                          </td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<table width="99%" border="0" cellspacing="0" cellpadding="0" class="righttableborder2">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px;">
                      <tr>
                        <td width="34%" height="25" class="text25">Policy Details</td>
                        <td width="34%" class="text25">Personal Details</td>
                        <td width="32%" class="text25">Agent Details</td>
                      </tr>
                      <tr>
                        <td valign="top">
                        <span class="mytext"><?php echo strtoupper($lic_reg["policy_no"]); ?></span><br />
                        <span class="mytextbold">Premium Amount : </span> Rs. <span class="mytext"><?php echo $lic_reg["premium_amount"]." ".$lic_reg["mode"]; ?></span> <br />
                        <span class="mytextbold">Date of commencement : </span> <span class="mytext"><?php echo date("jS M,Y",strtotime($lic_reg["date_commencement"])); ?></span> <br />
                        <span class="mytextbold">Date of Maturity : </span> <span class="mytext"><?php echo date("jS M,Y",strtotime($lic_reg["date_maturity"])); ?></span> <br />
                        <span class="mytextbold">Sum Assured  : </span> Rs. <span class="mytext"><?php echo $lic_reg["sum_assured"]; ?>/-</span> <br />
                        <span class="mytextbold">Nominee  : </span> <span class="mytext"><?php echo strtoupper($lic_reg["nominee"]); ?></span> <br />
                        <span class="mytextbold">Table &amp; Term  : </span> <span class="mytext"><?php echo $lic_reg["table_term"]; ?></span> <br />
                        <span class="mytextbold">Policy Branch  : </span> <span class="mytext"><?php echo strtoupper($lic_reg["policy_branch"]); ?></span> <br />
                        </td>
                        <td valign="top">
						<span class="mytextbold">Policy Holder Name :</span> <span class="mytext"><?php echo strtoupper($lic_reg["name_policy_holder"]); ?></span><br />
                        <span class="mytextbold">Date Of Birth :</span> <span class="mytext"><?php echo date("jS M,Y",strtotime($lic_reg["dob"])); ?></span><br />
                        <span class="mytextbold">Age :</span> <span class="mytext"><?php echo $lic_reg["age"]; ?></span>
                        </td>
                        <td valign="top">
                        <span class="mytextbold">Agent Name :</span> <span class="mytext"><?php echo strtoupper($lic_reg["name_agent"]); ?></span><br />
                        <span class="mytextbold">Agent contact No. :</span> <span class="mytext"><?php echo $lic_reg["agent_contact_no"]; ?></span><br />
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td id="td_show">
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                    <input name="add_premium" type="hidden" value="add">
					<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" style="margin-left:4px; border-collapse:collapse;">
                    <tr>
                      <td width="15%" align="center" valign="middle" bgcolor="#DDFBFA" class="text2">Premium Amount</td>
                      <td width="13%" align="center" valign="middle" bgcolor="#DDFBFA" class="text2">Payment Date</td>
                      <td width="16%" align="center" valign="middle" bgcolor="#DDFBFA" class="text2">Next Premium Date</td>
                      <td width="9%" align="center" valign="middle" bgcolor="#DDFBFA" class="text2">Alert Day </td>
                      <td width="12%" align="center" valign="middle" bgcolor="#DDFBFA" class="text2">Payment Mode</td>
                      <td width="13%" align="center" valign="middle" bgcolor="#DDFBFA" class="text2">Bank Name</td>
                      <td width="13%" align="center" valign="middle" bgcolor="#DDFBFA" class="text2">Chq/DD No.</td>
                      <td width="9%" bgcolor="#DDFBFA">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle">
                      <input name="premium_amount" type="text" class="textfield121d" id="premium_amount" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $lic_reg['premium_amount']; ?>"/>                      
                      </td><input type="hidden" name="premium_mode" id="premium_mode" value="<?php echo $lic_reg["mode"]; ?>" />
                      <td align="center" valign="middle"><input name="payment_date" type="text" class="datepick validate[required] textfield121d" id="payment_date" autocomplete="off" readonly/> </td>
                      <td align="center" valign="middle">
                      <input name="next_payment_date" type="text" class="datepick validate[required] textfield121d" id="next_payment_date" autocomplete="off" value="" readonly/>                      </td>
                      <td align="center" valign="middle"><input name="alert_lic" type="text" class="textfieldsmall" id="alert_lic" onKeyPress="return onlyNumbers(event);"/></td>
                      <td align="center" valign="middle">
                      <select name="mode_of_payment" id="mode_of_payment" class="validate[required]" onChange="showHide(this.value);">
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Draft">Draft</option>
                      </select>
                      </td>
                      <td align="center" valign="middle"><input name="bankname" type="text" class="textfield121d" id="bankname"/></td>
                      <td align="center" valign="middle"><input name="ddno" type="text" class="textfield121d" id="ddno" /></td>
                      <td align="center" valign="middle"><input name="submit" type="submit" class="button" id="submit" value="Submit"></td>
                    </tr>
                  </table>
                    </form>
                    </td>
                  </tr>                  
                   <tr>
                     <td>&nbsp;</td>
                   </tr>
                   <tr>
                     <td align="left" valign="top">
                    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%" style="margin-left:4px;">
                      <thead>
                      <tr>
                      <th width="4%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                      
                      <th width="10%" align="right" valign="middle" class="fetch_headers">Premium Amount</th>
                      <th width="12%" align="left" valign="middle" class="fetch_headers">Premium Mode</th>
                      <th width="11%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
                      <th width="11%" align="center" valign="middle" class="fetch_headers">Next<br>
                        Payment Date</th>
                      <th width="7%" align="center" valign="middle" class="fetch_headers">Alert day</th>
                      <th width="9%" align="center" valign="middle" class="fetch_headers">Payment<br>
                        Mode</th>
                      <th width="10%" align="left" valign="middle" class="fetch_headers">Bank Name</th>
                      <th width="17%" align="left" valign="middle" class="fetch_headers">Chq/DD No</th>
                      <th colspan="6" align="center" valign="middle" class="fetch_headers">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $count=1;
                      $str="policy_id='$_REQUEST[id]'";
                      $num=$db->countRows('premium_payment_details',$str);
                      foreach($db->fetchOrder("premium_payment_details",$str,"","") as $val_premium) { 
                      ?>
                      <?php if($num!=0) { ?>
                      <tr>
                      <td height="30" align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_premium["id"];?>"><?php echo $count; ?>
                      </td>
                      
                      <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($val_premium["premium_amount"],2); ?></td>
                      
                      <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_premium["premium_mode"]); ?></td>
                      <td align="center" valign="middle" class="fetch_contents"><?php echo date("d/mY",strtotime($val_premium["payment_date"])); ?></td>
                      <td align="center" valign="middle" class="fetch_contents"><?php echo date("d/m/Y",strtotime($val_premium["next_payment_date"])); ?></td>
                      <td align="center" class="fetch_contents"><?php echo $val_premium["alert_lic"]; ?></td>
                      <td align="left" valign="middle" class="fetch_contents">&nbsp;<?php echo $val_premium["pmode"];?></td>
                      <td align="left" class="fetch_contents">&nbsp;<?php echo $val_premium["bankname"];?></td>
                      <td align="left" valign="middle" class="fetch_contents">&nbsp;<?php echo $val_premium["ddno"];?></td>
                      <td width="4%" align="center" class="fetch_contents">
                      <a href="javascript:void(0);" onClick="editLicPremium(<?php echo $val_premium["id"];?>);">Edit</a>
                      </td>
                      <td width="5%" align="center">
                      <?php if($val_premium["status"] == 0){?>
                        <a href="add_premiums.php?action=approve&record_id=<?php echo $val_premium["id"];?>&id=<?php echo $_REQUEST["id"];?>">
                        <img src="images/pending.png" width="16" height="16" border="0" title="Click to Close Alert"></a>
                        <?php }else{ ?>
                        <a href="add_premiums.php?action=disapprove&record_id=<?php echo $val_premium["id"];?>&id=<?php echo $_REQUEST["id"];?>">
                        <img src="images/tick.png" width="16" height="16" border="0" title="Click to Display Alert"></a>
                        <?php } ?>
                      </td>
                      </tr>
                      <?php } ?>
                      <?php $count+=1;} ?>
                      <?php if($num==0) { ?>
                      <tr>
                      <td height="30" colspan="11" align="center" class="startext"><font color="#FF0000">No Records found.</font></td>
                      </tr>
                      <?php } ?>
                      </tbody>
                      </table>
                     </td>
                   </tr>
                   <tr>
                     <td align="left" valign="top">&nbsp;</td>
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
