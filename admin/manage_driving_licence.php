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

if(isset($_REQUEST['action']) && $_REQUEST['action']=="delete"){
	$db->deleteFromTable("driving_licence","id='$_REQUEST[id]'");
	header("Location:manage_driving_licence.php?msg=deleted");
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
           4: { 
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Manage Driving Licence</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="add_dl.php" class="linkButton">Add New </a></h2></td>
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
					<form action="manage_driving_licence.php" method="post" name="search">
					<table width="600" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="25%" align="right" valign="middle" class="text1">First Name / Last Name</td>
					    <td width="29%" class="text1"> :
					      <input name="search_by_name" type="text" id="search_by_name" class="textfield10"/>
					      </td>
					    <td width="11%" align="right" valign="middle"><span class="text1">DL No :</span></td>
					    <td width="25%"><input name="search_by_dlno" type="text" id="search_by_dlno" class="textfield10"/></td>
					    <td width="10%" align="right"><input type="image" name="imageField" src="images/searchButton.png"></td>
					    </tr>
					</table>
					</form>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center" valign="top">
					<table height="61" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                      <thead>
                        <tr>
                          <th width="26%" height="27" align="left" valign="middle" class="fetch_headers">Driver Name / Conatct No.</th>
                          <th width="26%" align="left" valign="middle" class="fetch_headers">Address</th>
                          <th width="18%" align="left" valign="middle" class="fetch_headers">DL NO.</th>
                          <th width="18%" align="left" valign="middle" class="fetch_headers">Referred Name / Mobile No.</th>
                          <th colspan="8" align="center" valign="middle" class="fetch_headers">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					  <?php
						$sch="";
						if(isset($_REQUEST['search_by_name']) && $_REQUEST['search_by_name']!="")
						{
							$sch="first_name like '%".$_REQUEST['search_by_name']."%' OR middle_name like '%".$_REQUEST['search_by_name']."%' OR last_name like '%".$_REQUEST['search_by_name']."%'";
						}
						if(isset($_REQUEST['search_by_dlno']) && $_REQUEST['search_by_dlno']!="")
						{
              if($sch !=''){
  							$sch=$sch." and dl_no='".$_REQUEST['search_by_dlno']."'";
              }
              else{
                $sch="dl_no='".$_REQUEST['search_by_dlno']."'";
              }
						}
						// $sch=substr($sch,0,-4);
						
						if($sch!='')
						{		
							 $src="select * from driving_licence where ".$sch."";
						}
						
						elseif($sch=='')
						{		
						   $src="select * from driving_licence";
						}
						$src_row=$db->mysqli->query($src);
						$num=$src_row->num_rows;
						?>
                        <?php
						 while($lice_info=$src_row->fetch_assoc())
						 {
							
			            ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
						  <?php  echo $lice_info['first_name']." ".$lice_info['middle_name']." ".$lice_info['last_name']." / ".$lice_info['contact_no'];  ?>
						
                          </td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $lice_info['address']; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $lice_info['dl_no']; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
                          <?php  echo $lice_info['referred_by']." / ".$lice_info['referer_mob_no'];  ?>
                          </td>
                          <td width="6%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                        <a href="edit_dl.php?id=<?php echo $lice_info['id'];?>" class="linktext"><img src="images/edit.png" width="18" height="18" title="Edit"></a>
                          </td>
                          <td width="6%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="manage_driving_licence.php?id=<?php echo $lice_info['id'];?>&action=delete" class="linktext" onClick="return confirm('Are you sure you want to delete all information of this vehicle?')"><img src="images/trash.jpg" width="18" height="18" title="Delete"></a>
                          </td>
                        </tr>
                        <?php } ?>
                        
                        <?php if($num==0) { ?>
                        <tr>
                          <td colspan="16" align="center" class="noRecords2"><font color="#FF0000">No Records Found !!!!</font></td>
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
