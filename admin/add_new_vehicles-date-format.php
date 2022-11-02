<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
$pageTitle='Add Panel';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
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
	$num=$db->countRows('hydro_pages',"page_name='$_REQUEST[page_name]'");
	if($num>0)
	{
		header("Location:add_pages.php?msg=error");
		exit;
	}
	else 
	{
	$dated=date("Y-m-d");
	$string="page_name='$_POST[page_name]',page_title='$_POST[page_title]',content='$_POST[content]',meta_title='$_POST[meta_title]',meta_descr='$_POST[meta_descr]',meta_keyword='$_POST[meta_keyword]',active_status='1',created_date='$dated'";
	$db->insertSet("hydro_pages",$string);
	header("Location:add_pages.php?msg=added");
	exit;
	}
}

?>
<!--date format-->
<script type="text/javascript" src="dtjs/typecast_1.js"></script>
<script type="text/javascript" src="dtjs/typecast.js"></script>
<script type="text/javascript">
	window.onload = go;
	function go(){
		Typecast.Init();
	}
	
	function checkDate(){
		var formName=document.frm;
		// define date string to test
		var txtDate = document.getElementById('loan_start_date').value;
		// check date and print message
		if (isDate(txtDate)) {
			document.getElementById("email_label").innerHTML='';
		}
		else {
			document.getElementById("email_label").innerHTML='Enter Valid Loan Start Date';
			formName.loan_start_date.focus();
			return false;
		}
	}
	
	function isDate(txtDate, separator) {
    var aoDate,           // needed for creating array and object
        ms,               // date in milliseconds
        month, day, year; // (integer) month, day and year
    // if separator is not defined then set '/'
    if (separator === undefined) {
        separator = '/';
    }
    // split input date to month, day and year
    aoDate = txtDate.split(separator);
    // array length should be exactly 3 (no more no less)
    if (aoDate.length !== 3) {
        return false;
    }
    // define month, day and year from array (expected format is m/d/yyyy)
    // subtraction will cast variables to integer implicitly
    month = aoDate[1] - 1; // because months in JS start from 0
    day = aoDate[0] - 0;
    year = aoDate[2] - 0;
    // test year range
    if (year < 1000 || year > 3000) {
        return false;
    }
    // convert input date to milliseconds
    ms = (new Date(year, month, day)).getTime();
    // initialize Date() object from milliseconds (reuse aoDate variable)
    aoDate = new Date();
    aoDate.setTime(ms);
    // compare input date and parts from Date() object
    // if difference exists then input date is not valid
    if (aoDate.getFullYear() !== year ||
        aoDate.getMonth() !== month ||
        aoDate.getDate() !== day) {
        return false;
    }
    // date is OK, return true
    return true;
}
<!--date format-->
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
                    <td bgcolor="#e2e2e2" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td bgcolor="#e2e2e2" valign="top" style="padding-left:20px;">
					<form action="" method="post" id="frm" name="frm" enctype="multipart/form-data" onSubmit="checkDate();">
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					    <tr>
					      <td width="17%" height="40" align="left" valign="middle">Vehicle No. <span class="startext">*</span> :</td>
					      <td width="14%" height="40" align="left" valign="middle">
                          <input name="vehicle_no" type="text" class="validate[required] textfield121" id="vehicle_no" autocomplete="off"/></td>
					      <td width="18%" height="40" align="left" valign="middle">&nbsp;</td>
					      <td width="16%" height="40" align="left" valign="middle">Total amount paid to bank <span class="startext">*</span> : </td>
					      <td width="35%" height="40" align="left" valign="middle">
                          <input name="total_amount_paid_to_bank" type="text" class="validate[required] textfield121" id="total_amount_paid_to_bank" autocomplete="off"/></td>
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
                          <input name="no_of_installment" type="text" class="validate[required] textfield121" id="no_of_installment" autocomplete="off"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Installment amount / month <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="installment_per_month" type="text" class="validate[required] textfield121" id="installment_per_month" autocomplete="off"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Rate of interest <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="rate_of_interest" type="text" class="validate[required] textfield121" id="rate_of_interest" autocomplete="off"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Loan start date <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="loan_start_date" type="text" class="TCMask[## ## ####,dd/mm/yyyy] textfield121" id="loan_start_date" autocomplete="off" />
                          </td>
					      <td height="40" align="left" valign="middle">&nbsp;<label id="email_label" class="level_msg"></label></td>
					      <td height="40" align="left" valign="middle">Finance By <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="finance_by" type="text" class="validate[required] textfield121" id="finance_by" autocomplete="off"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Loan end date <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="loan_end_date" type="text" class="validate[required] textfield121" id="loan_end_date" autocomplete="off"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Payment Bank<span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="payment_bank" type="text" class="validate[required] textfield121" id="payment_bank" autocomplete="off"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Finance amount <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="finance_amount" type="text" class="validate[required] textfield121" id="finance_amount" autocomplete="off"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Loan A/C No. <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="loan_ac_no" type="text" class="validate[required] textfield121" id="loan_ac_no" autocomplete="off"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">Interest amount <span class="startext">*</span> : </td>
					      <td height="40" align="left" valign="middle">
                          <input name="interest_amount" type="text" class="validate[required] textfield121" id="interest_amount" autocomplete="off"/></td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">Farm Name <span class="startext">*</span> :</td>
					      <td height="40" align="left" valign="middle">
                          <input name="farm_name" type="text" class="validate[required] textfield121" id="farm_name" autocomplete="off"/></td>
					      </tr>
					    <tr>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
					      <td height="40" align="left" valign="middle">&nbsp;</td>
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
