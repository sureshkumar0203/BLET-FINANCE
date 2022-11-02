<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
$pageTitle='Admin Panel';
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

if($_REQUEST[action]=="delete")
{
	$num=$dbf->countRows('installment_details',"vehi_id='$_REQUEST[vid]' AND payment_status='Paid'");
	if($num==0)
	{
		$db->deleteFromTable("new_vehicle_registration","id='$_REQUEST[vid]'");
		$db->deleteFromTable("installment_details","vehi_id='$_REQUEST[vid]'");
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

<!--table sorter ***************************************************** -->

	
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
           8: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 25});
	});
	</script>

<!--*******************************************************************-->
<script language="javascript" type="text/javascript">
/* ajax function to select Subcategory*/ 
function showSubcategory(catid)
{	
	var url="show_sub_category.php";	
	$.post(url,{"catid":catid},function(res)
	{ 						
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
                          <td width="50%" align="left" valign="middle"><h2>Manage Finance</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="add_new_vehicles.php" class="linkButton">Add New </a></h2></td>
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
					    <td width="34%" class="text1">Vehicle No. / Loan A/c No. </td>
					    <td width="16%">&nbsp;</td>
					    </tr>
					  <tr>
						<td width="50%" class="text1">
						  <select name="vehicle_type" class="dropdownWidth validate[required]" id="vehicle_type">
						    <option value="">--Select--</option>
						    <?php foreach($db->fetch('vehicle_types',"","vtype","","") as $val_veh) { ?>
						    <option value="<?php echo $val_veh[id]; ?>"><?php echo $val_veh[vtype]; ?></option>
						    <?php } ?>
						    </select>
						  </td>
						<td width="34%"><input name="all_search" type="text" id="all_search" class="textfield10"/></td>
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
					<table height="61" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                      <thead>
                        <tr>
                          <th width="10%" height="27" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
                          <th width="10%" align="left" valign="middle" class="fetch_headers">Vehicle Type</th>
                          <th width="13%" align="left" valign="middle" class="fetch_headers">Installment / Month</th>
                          <th width="10%" align="left" valign="middle" class="fetch_headers">Loan A/C No. </th>
                          <th width="12%" align="left" valign="middle" class="fetch_headers">Finance By</th>
                          <th width="12%" align="left" valign="middle" class="fetch_headers">Payment Bank</th>
                          <th width="8%" align="left" valign="middle" class="fetch_headers">Alert Day</th>
                          <th width="13%" align="left" valign="middle" class="fetch_headers">Tot. Installments<br>
 / Remaining</th>
                          <th colspan="7" align="center" valign="middle" class="fetch_headers">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					  <?php
						$sch="";
						if($_REQUEST[vehicle_type]!="")
						{
							$sch="vtype='$_REQUEST[vehicle_type]' AND ";
						}
						if($_REQUEST[all_search]!="")
						{
							$sch=$sch."vehicle_no='$_REQUEST[all_search]' OR loan_ac_no='$_REQUEST[all_search]' AND";
						}
						$sch=substr($sch,0,-4);
						
						if($sch!='')
						{		
							 $src="select * from new_vehicle_registration where ".$sch."";
						}
						
						elseif($sch=='')
						{		
						   $src="select * from new_vehicle_registration";
						}
						$src_row=$db->mysqli->query($src);
						$num=$src_row->num_rows;
						?>
                        <?php
						 while($veh_info=$src_row->fetch_assoc())
						 {
							$veh_typ=$db->fetchSingle("vehicle_types","id='$veh_info[vtype]'");
							$no_of_installment_remaining=$db->countRows('installment_details',"vehi_id=$veh_info[id] AND payment_status='Unpaid'");
			            ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td height="30" align="left" class="fetch_contents" style="padding-left:3px;">
						  <?php  echo $veh_info[vehicle_no];  ?>
                          </td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $veh_typ[vtype]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo $veh_info[installment_per_month]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $veh_info[loan_ac_no]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $veh_info[finance_by]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $veh_info[payment_bank]; ?></td>
                          <td align="center" class="fetch_contents"><?php echo $veh_info[alert_finance]; ?></td>
                          <td align="center" class="fetch_contents">
                          <font color="#009900">
						  <?php echo $veh_info[no_of_installment]; ?>
                          </font>
                          /
                          <font color="#FF0000">
                           <?php echo $no_of_installment_remaining; ?>
                          </font>
                          </td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="vehicle_details.php?id=<?php echo $veh_info[id];?>" class="linktext"><img src="images/view.png" width="18" height="18" title="View"></a>
                          </td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                          <a href="edit_new_vehicles.php?id=<?php echo $veh_info[id];?>" class="linktext"><img src="images/edit.png" width="18" height="18" title="Edit"></a>
                          </td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                          <a href="manage_new_vehicles.php?vid=<?php echo $veh_info[id];?>&action=delete" class="linktext"><img src="images/trash.jpg" width="18" height="18" title="Delete"></a>
                          </td>
                        </tr>
                        <?php } ?>
                        
                        <?php if($num==0) { ?>
                        <tr>
                          <td colspan="19" align="center" class="noRecords2"><font color="#FF0000">No Records Found !!!!</font></td>
                        </tr>
						<?php } ?>
                      </tbody>
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
