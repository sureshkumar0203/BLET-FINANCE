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

if(isset($_POST[submit])<>'')
{
	$string="password='$_POST[password]'";
	$db->updateTable("admin",$string,"id='1'");
	header("Location:change_password.php?msg=added");
}
$veh_info=$db->fetchSingle("new_vehicle_registration","id='$_REQUEST[id]'");
$veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vtype]'");
$no_of_installment_remaining=$db->countRows('installment_details',"vehi_id=$veh_info[id] AND payment_status='Unpaid'");
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--table sorter ***************************************************** -->

	
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
           6: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 25});
	});
	</script>

<!--*******************************************************************-->

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
                          <td width="50%" align="left" valign="middle"><h2>Vehicle Insurance History Detail</h2></td>
                          <td width="50%" align="right" valign="top" height="30">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="81%" align="right"><a href="manage_insurance.php"><img src="images/back.png" border="0" height="35"></a></td>
                          <td width="19%" align="right"><h2><a href="add_insurance.php" class="linkButton">Add </a></h2></td>
                        </tr>
                      </table>

                          </td>
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
                            <td width="40%" height="25" class="text1" style="padding-left:10px;">Vehicle No.</td>
                            <td width="7%" align="center" valign="middle" class="text1">:</td>
                            <td width="53%" height="25"><?php echo $veh_info[vehicle_no]; ?></td>
                          </tr>
                          <tr>
                            <td height="25" class="text1" style="padding-left:10px;">Vehicle type</td>
                            <td align="center" valign="middle" class="text1">:</td>
                            <td height="25"><?php echo $veh_type[vtype]; ?></td>
                          </tr>

                          <tr>
                            <td height="10" class="text1" style="padding-left:10px;"></td>
                            <td height="10" align="center" valign="middle" class="text1"></td>
                            <td height="10"></td>
                          </tr>
                        </table>
                          </td>
                          <td width="30%" style="padding-left:10px; padding-right:10px;">&nbsp;</td>
                          <td width="27%" style="padding-left:10px; padding-right:10px;" valign="top">&nbsp;</td>
                          <td width="23%" style="padding-left:10px; padding-right:10px;" valign="top">&nbsp;</td>
                        </tr>
                      </table></td>
                    <td>&nbsp;</td>
                  </tr>
				  
                  <tr>
                    <td width="10">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="12">&nbsp;</td>
                  </tr>
				  
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left">
                    <table height="61" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                      <thead>
                        <tr>
                          <th width="8%" height="27" align="center" valign="middle" class="fetch_headers">SL. No.</th>
                          <th width="34%" align="left" valign="middle" class="fetch_headers">Remark</th>
                          <th width="15%" align="left" valign="middle" class="fetch_headers">Insurance Start Date</th>
                          <th width="15%" align="left" valign="middle" class="fetch_headers">Insurance End Date</th>
                          <th width="10%" align="left" valign="middle" class="fetch_headers">Amount</th>
                          <th width="12%" align="left" valign="middle" class="fetch_headers">Payment Status</th>
                          <th width="12%" align="action" valign="middle" class="fetch_headers">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					   <?php
					   $count=1;
					   $str="vehi_id='$veh_info[id]' order by id DESC";
					   $num=$db->countRows('vehicle_insurance',$str);
					   foreach($db->fetchOrder("vehicle_insurance",$str,"","") as $val_insu) { 
					   ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td height="30" align="center" class="fetch_contents" style="padding-left:3px;">
						  <?php echo $count; ?>
                          </td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $val_insu[insurance_remark]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_insu[insurance_start_date])); ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($val_insu[insurance_end_date])); ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo $val_insu[insurance_amount]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
                            <?php if($val_insu[insurance_payment_status]=="Paid") { ?>
                            <font color="#009900"><?php echo $val_insu[insurance_payment_status]; ?></font> <?php } else { ?>
                            <font color="#FF0000"><?php echo $val_insu[insurance_payment_status]; ?></font> <?php } ?>
                            
                          </td>
                          <td align="center" class="fetch_contents">
                          <a href="edit_insurance.php?id=<?php echo $val_insu[id];?>" class="linktext"><img src="images/edit.png" width="18" height="18" title="Edit"></a></td>
                          </tr>
                        <?php $count+=1;} ?>
                      </tbody>
                    </table>
 
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right" style="padding-right:55px;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="76%" align="center">&nbsp;</td>
                        <td width="24%" >
						<?php if($num > 0) { ?>
						<form>
                          <div id="pager" class="pager" style="text-align:right; padding-top:10px;"> 
						  <img src="table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> 
						  <img src="table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                            <input name="text" type="text" class="pagedisplay trans" size="5" readonly=""/>
                            <img src="table_sorter/icons/next.png" width="16" height="16" class="next"/> 
							<img src="table_sorter/icons/last.png" width="16" height="16" class="last"/>
                            <select name="select" class="pagesize">
                              <option selected="selected"  value="25">25</option>
                              <option value="50">50</option>
                              <option  value="75">75</option>
							  <option  value="75">100</option>
                            </select>
                          </div>
                        </form>
						<?php } ?>	
                        </td>
                      </tr>
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
