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
?>
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
                          <td width="50%" align="left" valign="middle"><h2>Vehicle Road Tax Report</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="admin_home.php" class="linkButton">Cancel </a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <?php
			  $year_start_date = $_REQUEST["start_date"];
			  $year_end_date = $_REQUEST["end_date"];
			  ?>
              <tr>
                <td align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="10">&nbsp;</td>
                    <td height="35" align="left" valign="middle">
                    <form name="frm" id="frm">
                    <table width="80%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="11%" align="left">
                          <input name="start_date" type="text" id="start_date" class="textfield121d" readonly value="<?php echo $_REQUEST[start_date];?>"/>
                        </td>
                        <td width="12%" align="center" valign="middle">
                       <input name="end_date" type="text" id="end_date" class="textfield121d" readonly value="<?php echo $_REQUEST[end_date];?>"/></td>
                        <td width="10%" align="center" valign="middle">
                        <select name="firms" style="border:1px solid #CCC;" id="firms">
                        <option value="">-- All --</option>
                        <?php foreach($dbf->fetch('firms') as $res_firm) { ?>
                        <option value="<?php echo $res_firm[id];?>" <?php if($_REQUEST[firms]==$res_firm[id]) { echo "selected"; } ?>><?php echo $res_firm[firm_name];?></option>
                        <?php } ?>
                        </select>
                        </td>
                        <td width="8%" align="center" valign="middle"><input type="image" name="imageField" src="images/searchButton.png" /></td>
                        <td width="2%" align="center" valign="middle" bgcolor="#FF0000"><input type="checkbox" name="split" id="split" <?php if($_REQUEST[split]){?> checked="" <?php } ?>></td>
                        <td width="57%" align="left" valign="middle" class="forgottext">Click on red box to view the RTO Office wise report.</td>
                      </tr>
                    </table>
                    </form>
                    </td>
                    <td width="12">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="bottom">
                        <table width="50%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#006699">
                          <tr>
                            <td width="88%" align="center" valign="middle" bgcolor="#D7F2FF" class="text2">Vehicle Road Tax Paid list from <?php echo $_REQUEST[start_date];?> to <?php echo $_REQUEST[end_date];?></td>
                            <td width="12%" height="22" align="center" valign="middle" bgcolor="#990000" ><a href="report_road_tax_paid_csv.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&firms=<?php echo $_REQUEST[firms];?>">
                            <?php if($_REQUEST["split"] == ""){?>
                            <img src="images/xls.png" width="16" height="16" border="0" />
                            <?php } ?>
                            </a></td>
                          </tr>
                        </table>
                        <?php if($_REQUEST["split"] == ""){?>
                        <table height="89" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                          <thead>
                            <tr>
                                <th width="5%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                                <th width="16%" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
                                <th width="12%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
                                <th width="16%" align="left" valign="middle" class="fetch_headers">Owner Name</th>
                                <th width="20%" align="left" valign="middle" class="fetch_headers">RTO Office</th>
                                <th width="11%" align="right" valign="middle" class="fetch_headers">Tax Amount</th>                                <th width="8%" align="right" valign="middle" class="fetch_headers">Fine</th>                                <th width="12%" align="right" valign="middle" class="fetch_headers">Total Amount</th>
                             </tr>
                         </thead>
                        <tbody>
                        <?php
							$per_count = 1;
							$total = 0;
							$condition = "";
							if($_REQUEST[firms] != ""){
								$condition = " v.firm_name='$_REQUEST[firms]' And ";
							}
							$string = "select d.*,v.display_no,v.firm_name,v.rto_office from roadtax_details d,vehicle_registration v where ".$condition." v.id=d.vehicle_id And (d.date_of_payment between '$year_start_date' And '$year_end_date')";
							$inst_peri_row = mysql_query($string);
							$num = mysql_num_rows($inst_peri_row);
							while($vehicle_info=mysql_fetch_assoc($inst_peri_row)) {								
								$firm = $dbf->strRecordID("firms", "*", "id='$vehicle_info[firm_name]'");
								$rto = $dbf->strRecordID("rto_office", "*", "id='$vehicle_info[rto_office]'");
							?>
                        <tr>
                        <td align="center" class="fetch_contents"><?php echo $per_count; ?></td>
                        <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($vehicle_info['display_no']);?></td>                        
                        <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($vehicle_info[date_of_payment])); ?></td>                        <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($firm[firm_name]); ?></td>
                        <td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($rto[rto_name]); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[tax_amount],2); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[fine],2); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[total],2); ?></td>
                        </tr>
                        <?php 
						$total=$total+$vehicle_info[total];
						$per_count+=1;} ?>
                        <tr>
                          <td colspan="7" align="right" valign="middle" class="noRecords2">Total :</td>
                          <td align="right" valign="middle" class="noRecords2"><?php if($total >0){ echo number_format($total,2); }?>&nbsp;</td>
                        </tr>
                        </tbody>
                        <?php if($num == 0){?>
						<tr>
                          <td colspan="8" align="center" class="noRecords2">No records found !!!</td>
                        </tr>
                        <?php } ?>
                      </table>
                        <?php }else{?>
                        <?php						
                        foreach($dbf->fetchOrder('rto_office',"","") as $allrto){
							
							$is_exist = '';
							# Check the vehicle RTO Office wise
							foreach($dbf->fetchOrder('vehicle_registration',"rto_office='$allrto[id]'","") as $all_vehicle){
								
								$is_exist = $dbf->getDataFromTable("roadtax_details", "id", "vehicle_id='$all_vehicle[id]' And (date_of_payment between '$year_start_date' And '$year_end_date')");
								if($is_exist != ""){
									break;
								}
							}
							if($is_exist != ""){
						?>
                        <table height="89" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                        <thead>
                        <tr>
                        <th width="5%" height="27" align="center" valign="middle" class="fetch_headers"><a href="report_road_tax_paid_rto_csv.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&firms=<?php echo $_REQUEST[firms];?>&rto_office=<?php echo $allrto["id"];?>">
                            <img src="images/xls.png" width="16" height="16" border="0" />
                            </a></th>
                        <th width="16%" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
                        
                        <th width="12%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
                        <th width="16%" align="left" valign="middle" class="fetch_headers">Owner Name</th>
                        <th width="20%" align="left" valign="middle" class="fetch_headers">RTO Office</th>
                        <th width="11%" align="right" valign="middle" class="fetch_headers">Tax Amount</th>
                         <th width="8%" align="right" valign="middle" class="fetch_headers">Fine</th>
                         <th width="12%" align="right" valign="middle" class="fetch_headers">Total Amount</th>
                         </tr>
                        </thead>
                        <tbody>
                        <?php                        
						$per_count = 1;
						$total = 0;
						
						$condition = "";
						if($_REQUEST[firms] != ""){
							$condition = " v.firm_name='$_REQUEST[firms]' And ";
						}
						$string = "select d.*,v.display_no,v.firm_name,v.rto_office from roadtax_details d,vehicle_registration v where ".$condition." v.id=d.vehicle_id And (d.date_of_payment between '$year_start_date' And '$year_end_date')";
						$inst_peri_row = mysql_query($string);
						$num = mysql_num_rows($inst_peri_row);
						while($vehicle_info=mysql_fetch_assoc($inst_peri_row)) {								
							$firm = $dbf->strRecordID("firms", "*", "id='$vehicle_info[firm_name]'");
							$rto = $dbf->strRecordID("rto_office", "*", "id='$vehicle_info[rto_office]'");
							if($rto["id"] == $allrto["id"]){
							?>
                        <tr>
                        <td align="center" class="fetch_contents"><?php echo $per_count; ?></td>
                        <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($vehicle_info['display_no']);?></td>                        
                        <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($vehicle_info[date_of_payment])); ?></td>
                        <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($firm[firm_name]); ?></td>
                        <td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($rto[rto_name]); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[tax_amount],2); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[fine],2); ?></td>
                        <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[total],2); ?></td>
                        </tr>
                        <?php $total=$total+$vehicle_info[total];						
						$per_count+=1;}} ?>
                        <tr>
                          <td colspan="7" align="right" valign="middle" class="noRecords2">Total :</td>
                          <td align="right" valign="middle" class="noRecords2"><?php if($total >0){ echo number_format($total,2); }?>&nbsp;</td>
                        </tr>
                        </tbody>
                        <?php if($num == 0){?>
						<tr>
                          <td colspan="8" align="center" class="noRecords2">No records found !!!</td>
                        </tr>
                        <?php } ?>
                        </table>
                        <?php
							}							
						}
                        }
						?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="35" align="left" valign="bottom">
                            <table width="50%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#993300">
                          <tr>
                            <td width="88%" align="center" valign="middle" bgcolor="#FFE1E1" class="noRecords2">Vehicle Road Tax Pending from <?php echo $_REQUEST[start_date];?> to <?php echo $_REQUEST[end_date];?></td>
                            <td width="12%" align="center" valign="middle" bgcolor="#00CCCC"><a href="report_road_tax_unpaid_csv.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&firms=<?php echo $_REQUEST[firms];?>">
                            <?php if($_REQUEST["split"] == ""){?>
                            <img src="images/xls.png" width="16" height="16" border="0" />
                            <?php } ?>
                            </a></td>
                          </tr>
                        </table>
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle">
                            <?php if($_REQUEST["split"] == ""){?>
                            <table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                              <thead>
                                <tr>
                                  <th width="5%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                                  <th width="16%" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
                                  <th width="12%" align="center" valign="middle" class="fetch_headers">Tax From Date</th>
                                  <th width="16%" align="center" valign="middle" class="fetch_headers">Tax End Date</th>
                                  <th width="10%" align="center" valign="middle" class="fetch_headers">Owner Name</th>
                                  <th width="20%" align="center" valign="middle" class="fetch_headers">RTO Office</th>
                                  <th width="8%" align="center" valign="middle" class="fetch_headers">Alert Day(s)</th>
                                  <th width="13%" align="right" valign="middle" class="fetch_headers">Tax Amount</th>
                                  </tr>
                                </thead>
                            <?php
							$per_count = 1;
							$total = 0;
							$condition = "";
							if($_REQUEST[firms] != ""){
								$condition = " v.firm_name='$_REQUEST[firms]' And ";
							}
							$string = "select d.*,v.display_no,v.firm_name,v.rto_office from roadtax_pending d,vehicle_registration v where ".$condition." v.id=d.vehicle_id And (d.tax_to_dt between '$year_start_date' And '$year_end_date')";
							$inst_peri_row = mysql_query($string);
							$num = mysql_num_rows($inst_peri_row);
							while($vehicle_info=mysql_fetch_assoc($inst_peri_row)) {								
								$firm = $dbf->strRecordID("firms", "*", "id='$vehicle_info[firm_name]'");
								$rto = $dbf->strRecordID("rto_office", "*", "id='$vehicle_info[rto_office]'");
							?>
                            <tr>
                              <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($vehicle_info['display_no']);?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo date("jS M,Y",strtotime($vehicle_info['tax_from_dt']));?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo date("jS M,Y",strtotime($vehicle_info['tax_to_dt']));?></td>
                              <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $firm['firm_name']; ?></td>
                              <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $rto["rto_name"];?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo $vehicle_info["alert_tax"];?></td>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;">
							  <?php echo number_format($vehicle_info['tax_amount'],2); ?></td>
                              </tr>
                            <?php
                            $total = $total + $vehicle_info['tax_amount'];
							$per_count+=1;} ?>
                            <tr>
                              <td colspan="7" align="right" valign="middle" class="text2" style="padding-left:3px;">Total :</td>
                              <td align="right" valign="middle" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
                            </tr>
                        </table>
                            <?php }else{?>
                            <?php
							//id='$_REQUEST[rto_office]'
							foreach($dbf->fetchOrder('rto_office',"","") as $allrto){
								
								$is_exist = '';
								# Check the vehicle RTO Office wise
								foreach($dbf->fetchOrder('vehicle_registration',"rto_office='$allrto[id]'","") as $all_vehicle){
									
									$is_exist = $dbf->getDataFromTable("roadtax_pending", "id", "vehicle_id='$all_vehicle[id]' And (tax_to_dt between '$year_start_date' And '$year_end_date')");
									if($is_exist != ""){
										break;
									}
								}
								if($is_exist != ""){
							?>
                            <table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                              <thead>
                                <tr>
                                  <th width="5%" height="27" align="center" valign="middle" class="fetch_headers"><a href="report_road_tax_unpaid_rto_csv.php?start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>&firms=<?php echo $_REQUEST[firms];?>&rto_office=<?php echo $allrto["id"];?>">
                            <img src="images/xls.png" width="16" height="16" border="0" />
                            </a></th>
                                  <th width="16%" align="left" valign="middle" class="fetch_headers">Vehicle No.23</th>
                                  <th width="12%" align="center" valign="middle" class="fetch_headers">Tax From Date</th>
                                  <th width="16%" align="center" valign="middle" class="fetch_headers">Tax End Date</th>
                                  <th width="10%" align="center" valign="middle" class="fetch_headers">Owner Name</th>
                                  <th width="20%" align="center" valign="middle" class="fetch_headers">RTO Office</th>
                                  <th width="8%" align="center" valign="middle" class="fetch_headers">Alert Day(s)</th>
                                  <th width="13%" align="right" valign="middle" class="fetch_headers">Tax Amount</th>
                                  </tr>
                                </thead>
                            <?php
							$per_count = 1;
							$total = 0;
							
							$condition = "";
							if($_REQUEST[firms] != ""){
								$condition = " v.firm_name='$_REQUEST[firms]' And ";
							}
							$string = "select d.*,v.display_no,v.firm_name,v.rto_office from roadtax_pending d,vehicle_registration v where ".$condition." v.id=d.vehicle_id And (d.tax_to_dt between '$year_start_date' And '$year_end_date')";
							$inst_peri_row = mysql_query($string);
							$num = mysql_num_rows($inst_peri_row);
							while($vehicle_info=mysql_fetch_assoc($inst_peri_row)) {								
								$firm = $dbf->strRecordID("firms", "*", "id='$vehicle_info[firm_name]'");
								$rto = $dbf->strRecordID("rto_office", "*", "id='$vehicle_info[rto_office]'");
								if($rto["id"] == $allrto["id"]){
							?>
                            <tr>
                              <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($vehicle_info['display_no']);?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo date("jS M,Y",strtotime($vehicle_info['tax_from_dt']));?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo date("jS M,Y",strtotime($vehicle_info['tax_to_dt']));?></td>
                              <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $firm['firm_name']; ?></td>
                              <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $rto["rto_name"];?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo $vehicle_info["alert_tax"];?></td>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;">
							  <?php echo number_format($vehicle_info['tax_amount'],2); ?></td>
                              </tr>
                            <?php
                            $total = $total + $vehicle_info['tax_amount'];
							$per_count+=1;}} ?>
                            <tr>
                              <td colspan="7" align="right" valign="middle" class="text2" style="padding-left:3px;">Total :</td>
                              <td align="right" valign="middle" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
                            </tr>
                      </table>
                            <?php
								}
							}
                            }
							?>
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
