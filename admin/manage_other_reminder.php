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
	$num=$db->countRows('installment_details',"vehi_id='$_REQUEST[vid]' AND payment_status='Paid'");
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
                          <td width="50%" align="left" valign="middle"><h2>Manage Other Reminders</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="add_other_reminder.php" class="linkButton">Add </a></h2></td>
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
					<form action="manage_other_reminder.php" method="post" name="search">
					<table width="500" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="50%" class="text1" height="25">Alert Type</td>
					    <td width="34%" class="text1">Vehicle No. </td>
					    <td width="16%">&nbsp;</td>
					    </tr>
					  <tr>
						<td width="50%" class="text1">
						  <select name="alert_type" class="validate[required]" id="alert_type" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('alert_days',"id!=1","alert_type","","") as $val) { ?>
                            <option value="<?php echo $val[alert_type]; ?>"><?php echo $val[alert_type]; ?></option>
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
                          <th width="6%" height="27" align="left" valign="middle" class="fetch_headers">SL. No.</th>
                          <th width="9%" align="left" valign="middle" class="fetch_headers">Alert Type</th>
                          <th width="11%" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
                          <th width="10%" align="left" valign="middle" class="fetch_headers">Start Date</th>
                          <th width="9%" align="left" valign="middle" class="fetch_headers">End Date</th>
                          <th width="9%" align="left" valign="middle" class="fetch_headers">Amount</th>
                          <th width="13%" align="left" valign="middle" class="fetch_headers">
                          Payment Status / <br>
                          Paid Date
						</th>
                          <th width="29%" align="left" valign="middle" class="fetch_headers">Remark</th>
                          <th colspan="7" align="center" valign="middle" class="fetch_headers">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					  <?php
						$sch="";
						if($_REQUEST[alert_type]!="")
						{
							$sch="alert_type='$_REQUEST[alert_type]' AND ";
						}
						if($_REQUEST[all_search]!="")
						{
							$sch=$sch."vehicle_no='$_REQUEST[all_search]' AND";
						}
						$sch=substr($sch,0,-4);
						
						if($sch!='')
						{		
							 $src="select * from other_reminders where ".$sch."";
						}
						
						elseif($sch=='')
						{		
						   $src="select * from other_reminders";
						}
						//echo $src;
						$src_row=$db->mysqli->query($src);
						$num=$src_row->num_rows;
						?>
                        <?php
						$count=1;
						 while($rem_info=$src_row->fetch_assoc())
						 {
			            ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td height="30" align="center" class="fetch_contents"><?php echo $count; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo $rem_info[alert_type];  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $rem_info[vehicle_no]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($rem_info[start_date])); ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($rem_info[end_date])); ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php echo $rem_info[amount]; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
                          <font color="#009900">
						  <?php echo $rem_info[payment_status]." / ".date("jS M,Y",strtotime($rem_info[paid_date])); ?></font></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $rem_info[remark]; ?></td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="edit_other_reminder.php?id=<?php echo $rem_info[id];?>" class="linktext"><img src="images/edit.png" width="18" height="18" title="Edit"></a>
                          </td>
                        </tr>
                        <?php $count+=1;} ?>
                        
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
