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

if(isset($_REQUEST["action"])=="delete")
{
	$db->deleteFromTable("other_details","id='$_REQUEST[id]'");
	header("Location:manage_others.php?msg=deleted");

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
           5: { 
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
                          <td width="50%" align="left" valign="middle"><h2>Manage Others</h2></td>
                          <td width="39%" align="right" valign="middle">
                           <h2><a href="export_other_report.php?firm_id=<?php echo isset($_REQUEST["firm_id"]);?>&payment_head_id=<?php echo isset($_REQUEST["payment_head_id"]);?>&date_from=<?php echo isset($_REQUEST["date_from"]);?>&date_to=<?php echo isset($_REQUEST["date_to"]);?>&payment_status=<?php echo isset($_REQUEST["payment_status"]);?>" class="linkButton" style="padding-right:10px;">Export</a></h2>
                           </td>
                          <td width="11%" align="right" valign="middle"> <h2><a href="add_others.php" class="linkButton">Add New </a></h2></td>
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
					<form action="manage_others.php" name="search">
					<table width="750" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="19%" height="25" class="text1">Firm Name</td>
					    <td width="20%" class="text1">Payment Head</td>
					    <td width="19%" class="text1">Date from</td>
					    <td width="19%" class="text1">Date to</td>
					    <td width="13%" class="text1">Payment Status</td>
					    <td width="10%">&nbsp;</td>
					    </tr>
					  <tr>
						<td width="19%">
                        <select name="firm_id" class="validate[required]" id="firm_id" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('firms',"","firm_name","","") as $val) { ?>
                            <option value="<?php echo $val["id"]; ?>" <?php if(isset($_REQUEST["firm_id"]) &&  $_REQUEST["firm_id"]== $val["id"]){?> selected <?php } ?>><?php echo $val["firm_name"]; ?></option>
                             <?php } ?>
                          </select>
                          </td>
						<td width="20%">
                        <select name="payment_head_id" class="validate[required]" id="payment_head_id" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('payment_heads',"","heads","","") as $val_head) { ?>
                            <option value="<?php echo isset($val_head["id"]); ?>"><?php echo $val_head["heads"]; ?></option>
                             <?php } ?>
                          </select>
                        </td>
						<td width="19%"><input name="date_from" type="text" id="date_from" class="datepick validate[required] textfield121" readonly/></td>
						<td width="19%"><input name="date_to" type="text" id="date_to" class="datepickFuture validate[required] textfield121" readonly/></td>
						<td width="13%">
                        <select name="payment_status" class="validate[required]" id="payment_status" style="border:1px solid #CCC; width:100px; height:25px;">
                         <option value="">--Select--</option>
                        <option value="tobepaid" <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="tobepaid") { echo "Selected"; }?>>To be paid</option>
                        <option value="Paid" <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Paid") { echo "Selected"; }?>>Paid</option>
                        <option value="both" <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="both") { echo "Selected"; }?>>Both</option>
                        </select>
                        </td>
						<td width="10%" align="left"><input type="image" name="imageField" src="images/searchButton.png"></td>
					  </tr>
					</table>
					</form>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="1038" height="30" valign="middle" align="left" style="padding-left:20px;">
                    <?php if(isset($_REQUEST["msg"])=="deleted") { ?>
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
                          <th width="14%" height="27" align="left" valign="middle" class="fetch_headers">Firm Name</th>
                          <th width="16%" align="left" valign="middle" class="fetch_headers">Payment Head</th>
                          <th width="19%" align="left" valign="middle" class="fetch_headers">Paid to</th>
                          <th width="14%" align="right" valign="middle" class="fetch_headers">Amount</th>
                          <th width="25%" align="left" valign="middle" class="fetch_headers">
                          <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="tobepaid") { ?>Due Date <?php } ?>
                          <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Paid") { ?>Paid Date <?php } ?>
                          <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="both") { ?>Both <?php } ?>
                          <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="") { ?>Due Date / Paid Date<?php } ?>
                          </th>
                          <th colspan="8" align="center" valign="middle" class="fetch_headers">Action</th>
                          </tr>
                      </thead>
                      <tbody>
					  <?php
						$sch="";
						if(isset($_REQUEST["firm_id"]) && $_REQUEST["firm_id"]!="")
						{
							$sch="firm_id='".$_REQUEST['firm_id']."'";
						}
						
						if(isset($_REQUEST["payment_head_id"]) && $_REQUEST["payment_head_id"]!="")
						{
              if($sch !=''){
  							$sch=$sch." and payment_head_id='".$_REQUEST['payment_head_id']."'";
              }
              else{
                $sch="payment_head_id='".$_REQUEST['payment_head_id']."'";
              }
						}
					
						if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="tobepaid")
						{
              if ($_REQUEST['date_from']!='' && $_REQUEST['date_from']!='') {
                # code...
                if($sch !=''){
                  $sch=$sch." and date_to between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."'";
                }
                else{
    							$sch="date_to between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."'";
                }
              }
						}
						if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Paid")
						{
              if ($_REQUEST['date_from']!='' && $_REQUEST['date_from']!='') {
                if ($sch!='') {
                  $sch=$sch." and payment_date between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."'";
                }
                else{
  							$sch="payment_date between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."'";
                }
              }
						}
						if(isset($_REQUEST["payment_status"])=="both")
						{
              if ($_REQUEST['date_from']!='' && $_REQUEST['date_from']!='') {
                if($sch!=''){

    							$sch=$sch." and (date_to between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."') OR (payment_date between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."')";
                }
                else{
                 $sch= " (date_to between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."') OR (payment_date between '".$_REQUEST['date_from']."' AND '".$_REQUEST['date_to']."')"; 
                }
              }
						}
						// $sch=substr($sch,0,-4);
						//echo $sch;
						if($sch!='')
						{		
							 $src="select * from other_details where ".$sch." order by id DESC";
						}
						
						elseif($sch=='')
						{		
						   $src="select * from other_details order by id DESC";
						}
						//echo  $src;
						$src_row= $db->mysqli->query($src);
						$num=$src_row->num_rows;
						?>
                        <?php
						 $total="";
						 while($other_info=$src_row->fetch_assoc())
						 {
							  $firm_det=$db->fetchSingle("firms","id='$other_info[firm_id]'"); 
							  $payment_det=$db->fetchSingle("payment_heads","id='$other_info[payment_head_id]'"); 
							  $bank_det=$db->fetchSingle("bank_details","id='$other_info[bank_id]'"); 
			            ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
                           <?php  echo strtoupper($firm_det["firm_name"]);  ?>
                          </td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo $payment_det["heads"];  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo strtoupper($other_info["paid_to"]);  ?></td>
                          <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo number_format($other_info["amount"],2);  ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
						  <?php if(isset($_REQUEST["payment_status"])=="tobepaid") { ?>
						  <?php  echo date("jS M,Y",strtotime($other_info["date_to"]));  ?>
                          <?php } ?>
                          
                          <?php if(isset($_REQUEST["payment_status"])=="Paid") { ?>
						  <?php  echo date("jS M,Y",strtotime($other_info["payment_date"]));  ?>
                          <?php } ?>
                          
                          <?php if(isset($_REQUEST["payment_status"])=="both") { ?>
                          <font color="#FF0000"><?php  echo date("jS M,Y",strtotime($other_info["date_to"]));  ?> </font>- 
						  <font color="#009900"><?php  echo date("jS M,Y",strtotime($other_info["payment_date"]));  ?> </font>
                          <?php } ?>
                          
                          <?php if(isset($_REQUEST["payment_status"])=="") { ?>
						  <font color="#FF0000"><?php  echo date("jS M,Y",strtotime($other_info["date_to"]));  ?> </font>- 
						  <font color="#009900"><?php  echo date("jS M,Y",strtotime($other_info["payment_date"]));  ?> </font>
                          <?php } ?>
                          
                          
                          </td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="view_others.php?id=<?php echo $other_info["id"];?>" class="linktext"><img src="images/view.png" width="16" height="16" title="View"></a>
                          </td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                           <a href="edit_others.php?id=<?php echo $other_info["id"];?>" class="linktext"><img src="images/edit.png" width="18" height="18" title="Edit"></a>
                          </td>
                          <td width="4%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                            <a href="manage_others.php?id=<?php echo $other_info["id"];?>&action=delete" class="linktext" onClick="return confirm('Are you sure you want to delete this record?')"><img src="images/trash.jpg" width="15" height="16" title="Delete"></a>
                          </td>
                        </tr>
                        <?php $total=$total+$other_info["amount"]; } ?>
                       
                        <?php 
                       
                        if($num==0) { ?>
                        <tr>
                          <td colspan="17" align="center" class="noRecords2"><font color="#FF0000">No Records Found !!!!</font></td>
                        </tr>
						<?php }  ?>
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
                        <td width="76%" align="right" valign="middle" class="text1" style="padding-right:128px;"><p>Total = Rs. <?php if($total>0){echo number_format($total,2);} ?></p></td>
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
