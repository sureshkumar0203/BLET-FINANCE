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

if($_REQUEST[action]=="delete")
{
	$num=$dbf->countRows('installment_details',"vehi_id='$_REQUEST[vid]' AND payment_status='Paid'");
	if($num==0)
	{
		$dbf->deleteFromTable("new_vehicle_registration","id='$_REQUEST[vid]'");
		$dbf->deleteFromTable("installment_details","vehi_id='$_REQUEST[vid]'");
		header("Location:manage_new_vehicles.php?msg=deleted");
	}
	else
	{
		header("Location:manage_new_vehicles.php?msg=no");
		exit;
	}
}
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function show_details1(a)
{
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display=='')
	{
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="images/plus.gif" alt="Loading" />';
	}
	else
	{
		document.getElementById(a).style.display='';
		document.getElementById(arrow).innerHTML='<img src="images/minus.gif" alt="Loading" />';
	}
}
</script>

<script language="javascript" type="text/javascript">
function showForm(vid){
	//alert(pid);	
	var url="show_form.php";	
	$.post(url,{"vid":vid},function(res){ 
	//alert(res);						
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Manage Vehicles</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="vehicle_registration.php" class="linkButton">Add New </a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#e2e2e2" height="320">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center">
					<form action="manage_new_vehicles.php" method="post" name="search">
					<table width="500" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="50%" class="text1" height="25">Vehicle Type</td>
					    <td width="34%" class="text1">Vehicle No. </td>
					    <td width="16%">&nbsp;</td>
					    </tr>
					  <tr>
						<td width="50%" class="text1">
						  <select name="vehicle_type" class="dropdownWidth validate[required]" id="vehicle_type">
						    <option value="">--Select--</option>
						    <?php foreach($dbf->fetch('vehicle_types',"","vtype","","") as $val_veh) { ?>
						    <option value="<?php echo $val_veh[id]; ?>"><?php echo $val_veh[vtype]; ?></option>
						    <?php } ?>
						    </select>
						  </td>
						<td width="34%"><input name="vehicle_no" type="text" id="vehicle_no" class="textfield10"/></td>
					    <td width="16%" align="right"><input type="image" name="imageField" src="images/searchButton.png"></td>
					  </tr>
					</table>
					</form>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="1038" height="30" valign="middle" align="center">
                    <?php if($_REQUEST[msg]=="no") { ?>
                    <span class="error">You can not delete this record because some installments are already given.</span>
                    <?php } ?>
                     <?php if($_REQUEST[msg]=="deleted") { ?>
                    <span class="error">Record deleted successfully.</span>
                    <?php } ?>
                    
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center" valign="top">
                    <table width="100%" align="left">
                    <?php 
					foreach($dbf->fetch("vehicle_registration")as $vehi_info) {
					$veh_typ=$dbf->fetchSingle("vehicle_types","id='$vehi_info[vehicle_type]'");	 
					?>
                    <tr>
                      <td width="18" align="center" valign="top">
                      <a href="javascript:void(0);" onClick="show_details1('<?php echo "m".$vehi_info[id];?>');">
                      <span id="plusArrow<?php echo "m".$continent[id];?>"><img src="images/plus.gif" border="0" /></span></a>
                      </td>
                      <td width="1025" valign="top">
                      <span class="text25">Vehicle No. : </span><?php echo  $vehi_info[vehicle_no];?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                      <span class="text25">Vehicle Type : </span><?php echo  $veh_typ[vtype];?></td>
                    </tr>
                    <tr style="display:none;" id="<?php echo "m".$vehi_info[id];?>">
                    <td>&nbsp;</td>
                    <td>
				   <?php 
                   if($vehi_info[purchase_mode]=="Loan") {  ?>
                   <a href="javascript:void(0);" onClick="showForm(<?php echo $vehi_info[id];?>);">Finance</a>&nbsp;|&nbsp;<?php  } ?>
                    RT&nbsp;|&nbsp;
                    Insurance&nbsp;|&nbsp;
                    Fitness&nbsp;|&nbsp;
                    Permit
                    
                    
                            
                    </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td id="td_show"></td>
                    </tr>
                    <?php } ?>
                    </table>
                                          
                                          
                                          

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
                    <td align="right">
					<table width="94%" border="0" cellpadding="0" cellspacing="0" align="center">
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
