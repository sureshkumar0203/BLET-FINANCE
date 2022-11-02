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
        <td >&nbsp;</td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="3" align="left" valign="top"></td>
            </tr>
          <tr>
            <td align="left" valign="top" height="365"><?php //include 'left.php';?></td>
            <td width="10">&nbsp;</td>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>All Finance Report</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="admin_home.php" class="linkButton">Cancel </a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <?php
			  if($_REQUEST[yr] != ''){
				  $yr = $_REQUEST[yr];
			  }else{
				  $yr = date('Y');
			  }
			  ?>
              <tr>
                <td align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="35" align="left" valign="middle">
                      <form name="frm" id="frm">
                        <table width="40%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="23%" align="left">
                              <input name="yr" type="text" id="yr" class="textfield121d" value="<?php echo $yr;?>"/>
                              </td>
                            <td width="34%" align="left" valign="middle">
                              <select name="firms" style="border:1px solid #CCC;" id="firms">
                                <option value="">-- All --</option>
                                <?php foreach($dbf->fetch('firms') as $res_firm) { ?>
                                <option value="<?php echo $res_firm[id];?>" <?php if($_REQUEST[firms]==$res_firm[id]) { echo "selected"; } ?>><?php echo $res_firm[firm_name];?></option>
                                <?php } ?>
                                </select>
                              </td>
                            <td width="19%" align="left" valign="middle"><input type="image" name="imageField" src="images/searchButton.png" /></td>
                            <td width="24%" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="50%" align="center" valign="middle">&nbsp;</td>
                                <td width="50%" align="center" valign="middle"><a href="report_finance_full.php?yr=<?php echo $yr;?>&firms=<?php echo $_REQUEST[firms];?>"><img src="images/xls.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>
                        </form>
                    </td>
                    </tr>
                  <tr>
                    <td align="left" valign="bottom">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="middle">
                          <table border="2" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                            <thead>
                              <tr>
                                <th colspan="15" align="center" valign="middle" style="background-color:#FFF;">EMI PENDING LIST AS ON <?php echo date("M'Y");?></th>
                                </tr>
                              <tr>
                                <th width="3%" rowspan="2" align="center" valign="middle" class="fetch_headers">SL.</th>
                                <th width="10%" rowspan="2" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
                                <th width="5%" rowspan="2" align="center" valign="middle" class="fetch_headers">V.Type</th>
                                <th width="5%" rowspan="2" align="center" valign="middle" class="fetch_headers">Firm</th>
                                <th colspan="2" align="center" valign="middle" class="fetch_headers">LOAN</th>
                                <th colspan="5" align="center" valign="middle" class="fetch_headers">AMOUNT</th>
                                <th width="3%" rowspan="2" align="center" valign="middle" class="fetch_headers">INTT</th>
                                <th width="3%" rowspan="2" align="center" valign="middle" class="fetch_headers">                                  Inst.<br>
                                  Due</th>
                                <th width="9%" rowspan="2" align="center" valign="middle" class="fetch_headers">Fianance
                                  By</th>
                                <th width="12%" rowspan="2" align="center" valign="middle" class="fetch_headers">A/C No.</th>
                                </tr>
                              <tr>
                                <th width="7%" height="27" align="center" valign="middle" class="fetch_headers">                                  START</th>
                                <th width="7%" align="center" valign="middle" class="fetch_headers">                                  END</th>
                                <th width="7%" align="center" valign="middle" class="fetch_headers">Finance</th>
                                <th width="7%" align="center" valign="middle" class="fetch_headers">Interest</th>
                                <th width="8%" align="center" valign="middle" class="fetch_headers">Paid to FINC.</th>
                                <th width="7%" align="center" valign="middle" class="fetch_headers">EMI</th>
                                <th width="7%" align="center" valign="middle" class="fetch_headers">DUE</th>
                                </tr>
                              </thead>
                            <?php
							$year_start_date = $yr."-01-01";
							$year_end_date = $yr."-12-31";
							$end_date = ($yr - 1)."-12-31";
							$total = 0; $emi_total = 0; $finance_total = 0; $interest_total = 0; $loan_total = 0;
							$per_count=1;
							$condition = "";
							if($_REQUEST[firms] != ""){
								$condition = " v.firm_name='$_REQUEST[firms]' And ";
							}
							// select v.*,f.loan_start_date from vehicle_registration v,finance_details f where v.id=f.vehi_id order by v.loan_start_date
							//$str = "select v.* from vehicle_registration v,finance_details f where ".$condition." v.id=f.vehicle_id order by f.loan_end_date";
							
							//"select * from vehicle_registration where ".$condition." id in (select vehicle_id from finance_details) order by vehicle_type"
							
							//$str = "select vehicle_id from finance_details where loan_end_date>'$end_date' group by vehicle_id order by loan_end_date";
							//select * from (select * from finance_details ORDER BY id DESC) AS x GROUP BY vehicle_id  order by loan_end_date
							$str = "select * from (select * from finance_details ORDER BY id DESC) AS x where loan_end_date>'$end_date' GROUP BY vehicle_id  order by loan_end_date";
							$inst_peri_row=mysql_query($str);
                            while($finfo=mysql_fetch_assoc($inst_peri_row)) {
								
								$vehicle_info = $dbf->strRecordID("vehicle_registration", "*", "id='$finfo[vehicle_id]'");
								
								# Get total installment of a particular vehicle
								$total_install = $dbf->countRows("installment_details", "vehi_id='$vehicle_info[id]'");// And (next_payment_date between '$year_start_date' And '$year_end_date')
								//echo '<br>';
								# Get only UnPaid installment of a particular vehicle
								$paid_total_install = $dbf->countRows("installment_details", "vehi_id='$vehicle_info[id]' And payment_status='Paid'");
								
								//$paid_total_install = $dbf->countRows("installment_details", "vehi_id='$vehicle_info[id]' And payment_status='Paid'");
								
								//if($total_install > 0){
								//if($total_install != $paid_total_install){
									
								$firm = $dbf->strRecordID("firms", "*", "id='$vehicle_info[firm_name]'");
								$next_pay = $dbf->fetchSingle("installment_details","vehi_id='$vehicle_info[id]' And payment_status='Unpaid'");
								$veh_installment=$dbf->fetchSingle("finance_details","vehicle_id='$vehicle_info[id]'");
								$max_id = $dbf->getDataFromTable("finance_details", "max(id)", "vehicle_id='$vehicle_info[id]'");
								$veh_installment_end=$dbf->fetchSingle("finance_details","id='$max_id'");
								$type = $dbf->getDataFromTable("vehicle_types", "vtype", "id='$vehicle_info[vehicle_type]'");
								
								$bold = '';
								if($total_install == $paid_total_install){
									$bold = "font-weight:bold;color:#FF00FF;";
								}
								?>
                            <tr>
                              <td align="center"  class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php echo $per_count; ?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><a href="add_all_other_info.php?id=<?php echo $vehicle_info["id"];?>" target="_blank" style="text-decoration:none;<?php echo $bold;?>"><?php echo strtoupper($vehicle_info['display_no']);?></a></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php echo $type;?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php echo $firm['firm_name'];?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php  echo date("d-m-Y",strtotime($veh_installment['loan_start_date']));?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php  echo date("d-m-Y",strtotime($veh_installment_end['loan_end_date']));?></td>
                              <td align="right" valign="middle" class="fetch_contents"  style="padding-left:0px;<?php echo $bold;?>"><?php echo number_format($veh_installment["finance_amount"],0);?></td>
                              <?php $loan_total = $loan_total + $veh_installment["finance_amount"];?>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo number_format($veh_installment['interest_amount'],0); ?></td>
                              <?php $interest_total = $interest_total + $veh_installment['interest_amount'];?>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo number_format($veh_installment["total_amount_paid_to_bank"],0);?></td>
                              <?php $finance_total = $finance_total + $veh_installment["total_amount_paid_to_bank"];?>
                              <td align="right" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo number_format($veh_installment["installment_per_month"],0);?></td>
                              <?php $emi_total = $emi_total + $veh_installment["installment_per_month"];?>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo $veh_installment["installment_per_month"] * ($total_install - $paid_total_install);?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo $veh_installment["rate_of_interest"];?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>">
                                <?php echo ($total_install - $paid_total_install);?></td>
                              <td align="left" valign="middle" class="fetch_contents" style="padding-left:1px;<?php echo $bold;?>"><?php  echo $veh_installment["finance_by"];?></td>
                              <td align="left" valign="middle" class="fetch_contents" style="padding-left:1px;<?php echo $bold;?>"><?php echo strtoupper($veh_installment['loan_ac_no']);?></td>
                              </tr>
                            <?php
                            $total = $total + $veh_installment["installment_per_month"] * ($total_install - $paid_total_install);
							$per_count+=1;}//}}
							?>
                            <tr>
                              <td colspan="6" align="center" class="fetch_header">TOTAL</td>
                              <td align="right" valign="middle" class="fetch_header"><?php echo number_format($loan_total,0);?></td>
                              <td align="right" valign="middle" class="fetch_header"><?php echo number_format($interest_total,0);?></td>
                              <td align="right" valign="middle" class="fetch_header"><?php echo number_format($finance_total,0);?></td>
                              <td align="right" class="fetch_header"><?php echo number_format($emi_total,0);?></td>
                              <td align="right" valign="middle" class="fetch_header"><?php echo number_format($total,0);?></td>
                              <td align="center" valign="middle" class="fetch_contents">&nbsp;</td>
                              <td align="center" valign="middle" class="fetch_contents">&nbsp;</td>
                              <td align="left" valign="middle" class="fetch_contents">&nbsp;</td>
                              <td align="left" valign="middle" class="fetch_contents">&nbsp;</td>
                            </tr>
                            </table>
                          </td>
                      </tr>
                    </table>  
                      
                    </td>
                    </tr>
                  <tr>
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
