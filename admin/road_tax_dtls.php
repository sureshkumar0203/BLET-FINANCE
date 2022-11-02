<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Admin Panel';
include 'application_top.php';

//Object initialization
//$db = new User();

if(isset($_SESSION['admin_id'])==""){
	header("location:index.php");
	exit;
}

if($_REQUEST["action"] == "disapprove"){
	
	$db->updateTable("roadtax_pending", "status='0'", "id='$_REQUEST[record_id]'");
	header("Location:road_tax_dtls.php?vehicle_id=$_REQUEST[vehicle_id]");
	exit;
}
if($_REQUEST["action"] == "approve"){
	
	$db->updateTable("roadtax_pending", "status='1'", "id='$_REQUEST[record_id]'");
	header("Location:road_tax_dtls.php?vehicle_id=$_REQUEST[vehicle_id]");
	exit;
}
if($_REQUEST["action"] == "delete"){
	
	$db->deleteFromTable("roadtax_pending", "id='$_REQUEST[record_id]'");
	header("Location:road_tax_dtls.php?vehicle_id=$_REQUEST[vehicle_id]");
	exit;
}
if($_REQUEST["action"] == "deleteme"){
	
	$db->deleteFromTable("roadtax_details", "id='$_REQUEST[record_id]'");
	header("Location:road_tax_dtls.php?vehicle_id=$_REQUEST[vehicle_id]");
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
                          <td width="50%" align="right" valign="middle"><h2><a href="road_tax.php" class="linkButton">Cancel</a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <?php $veh_info=$db->strRecordID('vehicle_registration', "*", "id='$_REQUEST[vehicle_id]'");
			  $rto = $db->strRecordID("rto_office" , "*", "id='$veh_info[rto_office]'");
				$veh_typ=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");	
				$firm=$db->fetchSingle("firms","id='$veh_info[firm_name]'");
			  ?>
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
                    <td align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
					  <tr>
					    <td width="7%" height="20" align="left" valign="middle"><span class="text1">&nbsp;Vehicle No :</span></td>
					    <td width="16%" align="left" valign="middle" class="text25">&nbsp;<?php echo $veh_info["display_no"];?></td>
					    <td width="12%" align="right" valign="middle"><span class="fetch_header">Vehicle Type :</span></td>
					    <td width="12%" align="left" class="text2">&nbsp;<?php echo strtoupper($veh_typ[vtype]);?></td>
					    <td width="12%" align="right" valign="middle"><span class="fetch_header">Firm Name :</span></td>
					    <td width="12%" align="left" class="text2">&nbsp;<?php echo strtoupper($firm[firm_name]);?></td>
					    <td width="12%" align="right" valign="middle"><span class="fetch_header">RTO Office :</span></td>
					    <td width="17%" align="left" class="text2">&nbsp;<?php echo strtoupper($rto["rto_name"]);?></td>
					    </tr>
					  </table>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="40" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td width="50%" align="left" valign="middle"><table width="80%" border="1" bordercolor="#00CC00" cellspacing="0" cellpadding="0"  style="box-shadow: 5px 3px 55px #063; border-collapse:collapse;">
                                <tr>
                                  <td height="25" align="center" valign="middle" bgcolor="#D2FFFF" class="fetch_header">Paid Section</td>
                                </tr>
                              </table></td>
                              <td width="50%" align="center" valign="middle"><h2><a href="road_tax_add.php?vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>" class="linkButton">Add New</a></h2></td>
                            </tr>
                        </table></td>
                        <td align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                              <td width="50%" align="left" valign="middle"><table width="80%" border="1" bordercolor="#00CC00" cellspacing="0" cellpadding="0"  style="box-shadow: 5px 3px 55px #f00; border-collapse:collapse;">
                                <tr>
                                  <td height="25" align="center" valign="middle" bgcolor="#FFE6DF" class="fetch_header">Pending Section</td>
                                </tr>
                              </table></td>
                              <td width="50%" align="right" valign="middle"><h2><a href="road_tax_pending_add.php?vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>" class="linkButton">Add New</a></h2></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="50%" align="left" valign="top">
                        <table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                        <thead>
                        <tr>
                        <th width="7%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                        
                        <th width="16%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
                        <th width="21%" align="left" valign="middle" class="fetch_headers">Owner Name</th>
                        <th width="16%" align="right" valign="middle" class="fetch_headers">Tax Amount</th>
                         <th width="9%" align="right" valign="middle" class="fetch_headers">Fine</th>
                         <th width="15%" align="right" valign="middle" class="fetch_headers">Total</th>
                         <th colspan="6" align="center" valign="middle" class="fetch_headers">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count=1;
                        $str="vehicle_id='$_REQUEST[vehicle_id]'";
                        $num=$db->countRows('roadtax_details',$str);
                        foreach($db->fetchOrder("roadtax_details",$str,"","") as $val_tax) { 
                        ?>
                        <tr>
                        <td align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst[id];?>">
                        <font color="<?php echo $color; ?>"><?php echo $count; ?></font>
                        </td>
                        
                        <td align="left" class="fetch_contents" style="padding-left:3px;">
                          <font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_tax[date_of_payment])); ?></font>
                        </td>
                        
                        <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($val_tax[owner_name]); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($val_tax[tax_amount],2); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($val_tax[fine],2); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($val_tax[total],2); ?></td>
                        <td width="8%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                          <a href="road_tax_paid_edit.php?vehicle_id=<?php echo $_REQUEST[vehicle_id];?>&edit_id=<?php echo $val_tax[id];?>" ><img src="images/edit.png" width="16" height="16"></a>
                        </td>
                        <td width="8%" align="center" bgcolor="<?=$color;?>">
                        <a href="road_tax_dtls.php?action=deleteme&record_id=<?php echo $val_tax["id"];?>&vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>">
                        <img src="images/trash.jpg" width="16" height="16" border="0" title="Click to Delete"></a>
                        </td>
                        </tr>
                        <?php $count+=1;} ?>
                        </tbody>
                        <?php if($num == 0){?>
						<tr>
                          <td height="30" colspan="8" align="center" class="noRecords2">&nbsp;</td>
                        </tr>
                        <?php } ?>
                        </table>
                        </td>
                        <td width="50%" align="left" valign="top" style="padding-left:2px;">
                        <table height="89" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                        <thead>
                        <tr>
                        <th width="10%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                        
                        <th width="21%" align="left" valign="middle" class="fetch_headers">Tax from date</th>
                        <th width="19%" align="left" valign="middle" class="fetch_headers">Tax to date</th>
                        <th width="18%" align="right" valign="middle" class="fetch_headers">Tax Amount</th>
                         <th width="11%" align="left" valign="middle" class="fetch_headers">Alert day</th>
                        <th colspan="7" align="center" valign="middle" class="fetch_headers">Action</th>
                        </tr>
                        </thead>
                        
                        <?php
                        $count=1;
                        $str="vehicle_id='$_REQUEST[vehicle_id]'";
                        $num=$db->countRows('roadtax_pending',$str);
                        foreach($db->fetchOrder("roadtax_pending",$str,"","") as $val_tax) { 
                        ?>
                        <tr>
                        <td align="center" class="fetch_contents" style="padding-left:3px;" id="ANCH<?php echo $val_inst[id];?>">
                        <font color="<?php echo $color; ?>"><?php echo $count; ?></font>
                        </td>
                        
                        <td align="left" class="fetch_contents" style="padding-left:3px;">
                        <font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_tax[tax_from_dt])); ?></font>
                        </td>
                        
                        <td align="left" class="fetch_contents" style="padding-left:3px;">
                          <font color="<?php echo $color; ?>"><?php echo date("jS M,Y",strtotime($val_tax[tax_to_dt])); ?></font></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($val_tax[tax_amount],2); ?></td>
                        <td align="center" class="fetch_contents"><?php echo $val_tax[alert_tax]; ?></td>
                        <td width="7%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                        <?php if($val_tax["status"] == 0){?>
                        <a href="road_tax_dtls.php?action=approve&record_id=<?php echo $val_tax["id"];?>&vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>">
                        <img src="images/pending.png" width="16" height="16" border="0" title="Click to Close Alert"></a>
                        <?php }else{ ?>
                        <a href="road_tax_dtls.php?action=disapprove&record_id=<?php echo $val_tax["id"];?>&vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>">
                        <img src="images/tick.png" width="16" height="16" border="0" title="Click to Display Alert"></a>
                        <?php } ?>
                        </td>
                        <td width="7%" align="center" bgcolor="<?=$color;?>" class="fetch_contents"><a href="road_tax_unpaid_edit.php?vehicle_id=<?php echo $_REQUEST[vehicle_id];?>&edit_id=<?php echo $val_tax["id"];?>" ><img src="images/edit.png" width="16" height="16"></a></td>
                        <td width="7%" align="center" bgcolor="<?=$color;?>" class="fetch_contents">
                        <a href="road_tax_dtls.php?action=delete&record_id=<?php echo $val_tax["id"];?>&vehicle_id=<?php echo $_REQUEST["vehicle_id"];?>">
                        <img src="images/trash.jpg" width="16" height="16" border="0" title="Click to Delete"></a>
                        </td>
                        </tr>
                        <?php $count+=1;} ?>
                        <?php if($num == 0){?>
                        <tr>
                          <td colspan="12" align="center" class="noRecords2" >No record found...</td>
                        </tr>
                        <?php } ?>
                        
                        </table>
                        </td>
                      </tr>
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
