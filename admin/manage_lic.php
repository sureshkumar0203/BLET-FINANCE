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

if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="delete")
{
	$num=$db->countRows('premium_payment_details',"policy_id='$_REQUEST[id]'");
	if($num==0)
	{
		$db->deleteFromTable("lic_registration","id='$_REQUEST[id]'");
		header("Location:manage_lic.php?msg=deleted");
	}
	else
	{
		header("Location:manage_lic.php?msg=no");
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
           7: { 
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Manage LIC</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="lic_registration.php" class="linkButton">Add New </a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center">
					<form action="manage_lic.php" method="post" name="search">
					<table width="500" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="43%"><span class="text1">Name&nbsp;/&nbsp;Policy&nbsp;No.&nbsp;/&nbsp;Agent&nbsp;contact&nbsp;No&nbsp;:&nbsp;</span></td>
					    <td width="30%">
					      <input name="name_policy_no_contact_no" type="text" id="name_policy_no_contact_no" class="textfield10" style="text-transform:uppercase;"/></td>
					    <td width="27%" align="left"><input type="image" name="imageField" src="images/searchButton.png"></td>
					    </tr>
					</table>
					</form>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="1038" height="30" valign="middle" align="center">
                    <?php if(isset($_REQUEST["msg"]) && $_REQUEST["msg"]=="no") { ?>
                    <span class="error">You can not delete this record because some premiums are already given.</span>
                    <?php } ?>
                     <?php if(isset($_REQUEST["msg"]) && $_REQUEST["msg"]=="deleted") { ?>
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
                          <th width="14%" height="27" align="left" valign="middle" class="fetch_headers">Name</th>
                          <th width="9%" align="left" valign="middle" class="fetch_headers">Policy No.</th>
                          <th width="12%" align="left" valign="middle" class="fetch_headers">Premium Amount</th>
                          <th width="13%" align="left" valign="middle" class="fetch_headers">Date of Maturity</th>
                          <th width="15%" align="left" valign="middle" class="fetch_headers">Name of agent</th>
                          <th width="13%" align="left" valign="middle" class="fetch_headers">Agent contact No.</th>
                          <th width="14%" align="left" valign="middle" class="fetch_headers">Policy Branch</th>
                          <th colspan="8" align="center" valign="middle" class="fetch_headers">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					  <?php
						$sch="";
						if(isset($_REQUEST["name_policy_no_contact_no"]) && $_REQUEST["name_policy_no_contact_no"]!="")
						{
							$sch="name_policy_holder like '%$_REQUEST[name_policy_no_contact_no]%' OR policy_no='$_REQUEST[name_policy_no_contact_no]' OR agent_contact_no='$_REQUEST[name_policy_no_contact_no]' AND ";
						}
						$sch=substr($sch,0,-4);
						
						if($sch!='')
						{		
							 $src="select * from lic_registration where ".$sch."";
						}
						
						elseif($sch=='')
						{		
						   $src="select * from lic_registration";
						}
						$src_row=$db->mysqli->query($src);
						$num=$src_row->num_rows;
						?>
                        <?php
						 while($lic_info=$src_row->fetch_assoc())
						 {
						 	//print_r($lic_info);exit;
			            ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
                           <?php  echo strtoupper($lic_info["name_policy_holder"]);  ?>
                          </td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo strtoupper($lic_info["policy_no"]);  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php  echo $lic_info["premium_amount"];  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
						  <?php  
						  $dateTime = new DateTime($lic_info["date_maturity"]);
						  echo $dateTime->format('jS M, Y'); // 15th Apr 2010
						  ?>
                          </td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo strtoupper($lic_info["name_agent"]);  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo $lic_info["agent_contact_no"];  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo strtoupper($lic_info["policy_branch"]);  ?></td>
                          <td width="3%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="add_premiums.php?id=<?php echo $lic_info["id"];?>" class="linktext"><img src="images/view.png" width="18" height="18" title="View"></a>
                          </td>
                          <td width="3%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                         <a href="edit_lic_details.php?id=<?php echo $lic_info["id"];?>" class="linktext"><img src="images/edit.png" width="18" height="18" title="Edit"></a>
                          </td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="manage_lic.php?id=<?php echo $lic_info["id"];?>&action=delete" class="linktext" onClick="return confirm('Are you sure you want to delete all informations of this policy?')"><img src="images/trash.jpg" width="18" height="18" title="Delete"></a>
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
            </table></td>
            </tr>
        </table></td>
        <td width="10">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><?php include 'footer.php';?></td>
  </tr>
</table>
</body>
</html>
