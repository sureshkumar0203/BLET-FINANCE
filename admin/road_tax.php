<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
$pageTitle='Admin Panel';
include 'application_top.php';
//Object initialization
$dbf = new User();

if(isset($_SESSION['admin_id'])==""){
	header("location:index.php");
	exit;
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
           9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
        } 
    })			
.tablesorterPager({container: $("#pager"), size: 25});
});
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
                          <td width="50%" align="left" valign="middle"><h2> Vehicles Road Tax</h2></td>
                          <td width="50%" align="right" valign="middle"></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" >
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top" style="padding-left:5px;">
					<form name="search" id="search">
					<table width="40%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="13%" class="text1">&nbsp;</td>
					    <td width="21%" align="right" valign="middle"><span class="text1">Vehicle No :</span></td>
						<td width="39%"><input name="vehicle_no" type="text" id="vehicle_no" class="textfield10" style="text-transform:uppercase;" value="<?php echo $_REQUEST["vehicle_no"];?>"/></td>
					    <td width="27%" align="left"><input type="image" name="imageField" src="images/searchButton.png"></td>
					  </tr>
					</table>
					</form>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center" valign="top">
					<table height="61" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#ACACAC" class="tablesorter" id="sort_table" width="100%">
                      <thead>
                        <tr>
                          <th width="4%" align="center" valign="middle" class="fetch_headers">&nbsp;</th>
                          <th width="11%" height="27" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
                          <th width="10%" align="left" valign="middle" class="fetch_headers">Vehicle Type</th>
                          <th width="5%" align="center" valign="middle" class="fetch_headers">No.  <br>of Axle</th>
                          <th width="7%" align="center" valign="middle" class="fetch_headers">Carrying <br>Capacity</th>
                          <th width="14%" align="left" valign="middle" class="fetch_headers">Model</th>
                          <th width="9%" align="center" valign="middle" class="fetch_headers">RTO Office</th>
                          <th width="11%" align="right" valign="middle" class="fetch_headers">Cost of vehicle</th>
                          <th width="10%" align="left" valign="middle" class="fetch_headers">Firm Name</th>
                          <th width="9%" align="center" valign="middle" class="fetch_headers">Purchase Mode </th>
                          <th colspan="6" align="center" valign="middle" class="fetch_headers">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					  <?php
						$sch="";
						if($_REQUEST["vehicle_no"]!=""){
							$sch=$sch."vehicle_no like '%$_REQUEST[vehicle_no]%' AND";
						}
						$sch=substr($sch,0,-4);						
						if($sch!=''){		
							 $src="select * from vehicle_registration where ".$sch."";
						}elseif($sch==''){
						   $src="select * from vehicle_registration";
						}
						$k = 1;
						$src_row=mysql_query($src);
						$num=mysql_num_rows($src_row);
						
						while($veh_info=mysql_fetch_assoc($src_row)){
							$firm = $dbf->strRecordID("firms", "*", "id='$veh_info[firm_name]'");
							$veh_typ = $dbf->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");
							$rto = $dbf->fetchSingle("rto_office","id='$veh_info[rto_office]'");
							$no_of_installment_remaining = $dbf->countRows('installment_details',"vehi_id=$veh_info[id] AND payment_status='Unpaid'");
			            ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td align="center" class="fetch_contents"><?php echo $k;?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
                           <?php  echo strtoupper($veh_info[display_no]);  ?>
                          </td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($veh_typ["vtype"]); ?></td>
                          <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo $veh_info["no_of_axle"];  ?></td>
                          <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo $veh_info["carrying_capacity"];  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo strtoupper($veh_info["vehicle_model"]);  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo $rto["rto_name"];?></td>
                          <td align="right" class="fetch_contents" style="padding-left:3px;"><?php  echo number_format($veh_info["cost_of_vehicle"],2);?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo strtoupper($firm["firm_name"]);  ?></td>
                          <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($veh_info["purchase_mode"]); ?></td>
                          <td width="3%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="road_tax_dtls.php?vehicle_id=<?php echo $veh_info["id"];?>" class="linktext"><img src="images/road.png" width="16" height="16"></a>
                          </td>
                          </tr>
                        <?php $k++; } ?>                        
                        <?php if($num==0) { ?>
                        <tr>
                          <td colspan="20" align="center" class="noRecords2"><font color="#FF0000">No Records Found !!!!</font></td>
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
                        <td width="24%" align="left" valign="top" >
						<?php if($num > 0) { ?>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><?php include 'footer.php';?></td>
  </tr>
</table>
</body>
</html>
