<?php
ob_start();
//session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='Admin Panel';

//Object initialization
//$dbf = new User();
if(isset($_REQUEST["yr"]) != ''){
  $yr = $_REQUEST["yr"];
}else{
  $yr = date('Y');
}
?>
<style>
.text2{font-family:Arial, Helvetica, sans-serif;font-size:8px;color:#0C8EBA;font-weight:bold;} 
.fetch_headers {font-family:Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color:#000000;border-bottom:solid 1px #ACACAC;white-space:nowrap;padding-left:5px;}
.fetch_contents {font-family:Arial, Helvetica, sans-serif;font-size: 12px;color:#000000;border-bottom:solid 1px #ACACAC;white-space:nowrap;padding-left:5px;}
</style>
<body>
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
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
                                <td width="7%" height="27" align="center" valign="middle" class="fetch_headers">                                  START</td>
                                <td width="7%" align="center" valign="middle" class="fetch_headers">                                  END</td>
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
							if(isset($_REQUEST["firms"]) != ""){
								$condition = " v.firm_name='$_REQUEST[firms]' And ";
							}
							// select v.*,f.loan_start_date from vehicle_registration v,finance_details f where v.id=f.vehi_id order by v.loan_start_date
							//$str = "select v.* from vehicle_registration v,finance_details f where ".$condition." v.id=f.vehicle_id order by f.loan_end_date";
							
							//"select * from vehicle_registration where ".$condition." id in (select vehicle_id from finance_details) order by vehicle_type"
							
							//$str = "select vehicle_id from finance_details where loan_end_date>'$end_date' group by vehicle_id order by loan_end_date";
							//select * from (select * from finance_details ORDER BY id DESC) AS x GROUP BY vehicle_id  order by loan_end_date
							$str = "select * from (select * from finance_details ORDER BY id DESC) AS x where loan_end_date>'$end_date' GROUP BY vehicle_id  order by loan_end_date";
							$inst_peri_row=$db->mysqli->query($str);
                            while($finfo=$inst_peri_row->fetch_assoc()) {
								
								$vehicle_info = $db->strRecordID("vehicle_registration", "*", "id='$finfo[vehicle_id]'");
								
								# Get total installment of a particular vehicle
								$total_install = $db->countRows("installment_details", "vehi_id='$vehicle_info[id]'");// And (next_payment_date between '$year_start_date' And '$year_end_date')
								//echo '<br>';
								# Get only UnPaid installment of a particular vehicle
								$paid_total_install = $db->countRows("installment_details", "vehi_id='$vehicle_info[id]' And payment_status='Paid'");
								
								//$paid_total_install = $db->countRows("installment_details", "vehi_id='$vehicle_info[id]' And payment_status='Paid'");
								
								//if($total_install > 0){
								//if($total_install != $paid_total_install){
									
								$firm = $db->strRecordID("firms", "*", "id='$vehicle_info[firm_name]'");
								$next_pay = $db->fetchSingle("installment_details","vehi_id='$vehicle_info[id]' And payment_status='Unpaid'");
								$veh_installment=$db->fetchSingle("finance_details","vehicle_id='$vehicle_info[id]'");
								$max_id = $db->getDataFromTable("finance_details", "max(id)", "vehicle_id='$vehicle_info[id]'");
								$veh_installment_end=$db->fetchSingle("finance_details","id='$max_id'");
								$type = $db->getDataFromTable("vehicle_types", "vtype", "id='$vehicle_info[vehicle_type]'");
								
								$bold = '';
								if($total_install == $paid_total_install){
									$bold = "font-weight:bold;color:#FF00FF;";
								}
								$no_of_fin = $db->countRows("finance_details", "vehicle_id='$vehicle_info[id]'");
								
								?>
                            <tr>
                              <td align="center"  class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php echo $per_count; ?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php echo strtoupper($vehicle_info['display_no']);?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php echo $type;?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>"><?php echo $firm['firm_name'];?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>">
							  <table width="100" border="0" cellspacing="0" cellpadding="0">
                              	<?php
								$z = 0; foreach($db->fetchOrder('finance_details', "vehicle_id='$vehicle_info[id]'","id") as $fee) {
									?>
                                <tr>
                                	<td align="center" height="22" valign="middle" <?php if($z >0 ){?> style="border-top:solid 1px; border-color:#999;" <?php }?>><?php echo date("d.m.Y",strtotime($fee['loan_start_date']));?><?php if($no_of_fin > 1){?> to <?php echo date("d.m.Y",strtotime($fee['loan_end_date']));?><?php }?></td>
                              	</tr>
                                <?php $z++; }?>
                              </table>
							  </td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;<?php echo $bold;?>">
							  <?php  echo date("d.m.Y",strtotime($veh_installment_end['loan_end_date']));?>
							  </td>
                              <td align="right" valign="middle" class="fetch_contents"  style="padding-left:0px;<?php echo $bold;?>"><?php echo number_format($veh_installment["finance_amount"],0);?></td>
                              <?php $loan_total = $loan_total + $veh_installment["finance_amount"];?>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo number_format($veh_installment['interest_amount'],0); ?></td>
                              <?php $interest_total = $interest_total + $veh_installment['interest_amount'];?>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo number_format($veh_installment["total_amount_paid_to_bank"],0);?></td>
                              <?php $finance_total = $finance_total + $veh_installment["total_amount_paid_to_bank"];?>
                              <td align="right" style="padding-left:0px;<?php echo $bold;?>">
							  <table width="100" border="0" cellspacing="0" cellpadding="0">
                              	<?php
								$z = 0; foreach($db->fetchOrder('finance_details', "vehicle_id='$vehicle_info[id]'","id") as $fee) {
									$emi_total = $emi_total + $fee["installment_per_month"];
									?>
                                <tr>
                                	<td align="right" height="22" valign="middle" <?php if($z >0 ){?> style="border-top:solid 1px; border-color:#999;" <?php }?>><?php echo number_format($fee["installment_per_month"],0);?></td>
                              	</tr>
                                <?php $z++; }?>
                              </table>
							  </td>
                              <?php //$emi_total = $emi_total + $veh_installment["installment_per_month"];?>
							  <?php $veh_installment["installment_per_month"] * ($total_install - $paid_total_install);?>
                              <td align="right" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>">
                              <table width="100" border="0" cellspacing="0" cellpadding="0">
                              	<?php $z = 0; foreach($db->fetchOrder('finance_details', "vehicle_id='$vehicle_info[id]'","id") as $fee) {
									
									# Get number of installment for each finance
									$pending_install = $db->countRows("installment_details", "finance_id='$fee[id]' And payment_status <> 'Paid'");
									$due_amount = $pending_install * $fee["installment_per_month"];
									$total = $total + $due_amount;
									?>
                                <tr>
                                	<td align="right" height="22" valign="middle" <?php if($z >0 ){?> style="border-top:solid 1px; border-color:#999;" <?php }?>><?php echo number_format($due_amount,0);?></td>
                              	</tr>
                                <?php $z++; }?>
                              </table>
							  </td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>"><?php echo $veh_installment["rate_of_interest"];?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:0px;<?php echo $bold;?>">
                                <?php echo ($total_install - $paid_total_install);?></td>
                              <td align="left" valign="middle" class="fetch_contents" style="padding-left:1px;<?php echo $bold;?>"><?php  echo $veh_installment["finance_by"];?></td>
                              <td align="left" valign="middle" class="fetch_contents" style="padding-left:1px;<?php echo $bold;?>"><?php echo strtoupper($veh_installment['loan_ac_no']);?></td>
                              </tr>
                            <?php
                            //$total = $total + $veh_installment["installment_per_month"] * ($total_install - $paid_total_install);
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
</body>
</html>
