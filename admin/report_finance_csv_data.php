<?php
ob_start();
session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//Object initialization
//$db = new User();

if($_REQUEST[yr] != ''){
  $yr = $_REQUEST[yr];
}else{
  $yr = date('Y');
}
?>
<style>
.fetch_headers {font-family:Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color:#000000;border-bottom:solid 1px #ACACAC;white-space:nowrap;padding-left:5px;}
table.tablesorter {font-family:arial;background-color: #CDCDCD;margin-top:10px;font-size: 12px;width:100%;border-collapse:collapse;text-align: left;}
/*change this coolor for header*/
table.tablesorter thead tr th, table.tablesorter tfoot tr th {background-color:#ccc;font-size: 11px;padding: 2px;font-weight:bold;color:#000;}
table.tablesorter thead tr .header {background-image: url(bg.gif);background-repeat: no-repeat;background-position: center right;cursor: pointer;}
table.tablesorter tbody td {color: #000000;	padding: 4px;	background-color: #FFF;	vertical-align: middle;	font-size:11px;}
</style>
<table height="61" border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
  <thead>
    <tr>
      <th width="4%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
      <th width="14%" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
      <th width="18%" align="left" valign="middle" class="fetch_headers">Firm Name.</th>
      <th width="12%" align="center" valign="middle" class="fetch_headers">Loan Start</th>
      <th width="12%" align="center" valign="middle" class="fetch_headers">Loan End</th>
      <th width="12%" align="center" valign="middle" class="fetch_headers">Inst. [%]</th>
      <th width="12%" align="center" valign="middle" class="fetch_headers">No.of<br />
installment</th>
      <th width="12%" align="center" valign="middle" class="fetch_headers">No.of <br />
      Paid Inst.</th>
      <th width="12%" align="center" valign="middle" class="fetch_headers">No of <br />
      Due Inst.</th>
      <th width="14%" align="center" valign="middle" class="fetch_headers">Next Payment Date</th>
      <th width="14%" align="right" valign="middle" class="fetch_headers">Installment<br />
Amount</th>
    </tr>
  </thead>
    <?php
    $year_start_date = $yr."-01-01";
    $year_end_date = $yr."-12-31";
    $total = 0;
    $per_count=1;
    $condition = "";
    if($_REQUEST[firms] != ""){
        $condition = " firm_name='$_REQUEST[firms]' And ";
    }
    
    $inst_peri_row=$db->mysqli->query("select * from vehicle_registration where ".$condition." id in (select vehicle_id from finance_details)");
    while($vehicle_info=$inst_peri_row->fetch_assoc()) {
        
        # Get total installment of a particular vehicle
        $total_install = $db->countRows("installment_details", "vehi_id='$vehicle_info[id]' And (next_payment_date between '$year_start_date' And '$year_end_date')");
        # Get only UnPaid installment of a particular vehicle
        $paid_total_install = $db->countRows("installment_details", "vehi_id='$vehicle_info[id]' And (next_payment_date between '$year_start_date' And '$year_end_date') And payment_status='Paid'");
        
        if($total_install > 0){
        if($total_install != $paid_total_install){
            
        $firm = $db->strRecordID("firms", "*", "id='$vehicle_info[firm_name]'");
        $next_pay = $db->fetchSingle("installment_details","vehi_id='$vehicle_info[id]' And payment_status='Unpaid'");
        $veh_installment=$db->fetchSingle("finance_details","vehicle_id='$vehicle_info[id]'");
        ?>
    <tr>
      <td align="center" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
      <td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($vehicle_info['vehicle_no']);?></td>
      <td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $firm['firm_name'];  ?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php  echo date("jS M,Y",strtotime($veh_installment['loan_start_date']));?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php  echo date("jS M,Y",strtotime($veh_installment['loan_end_date']));?></td>
      <td align="center" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><span class="fetch_contents" style="padding-left:3px;"><?php echo number_format($veh_installment['rate_of_interest'],2); ?></span></td>
      <td align="center" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $total_install;?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $paid_total_install;?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $total_install - $paid_total_install;?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;">
      <?php  echo date("jS M,Y",strtotime($next_pay[next_payment_date]));?></td>
      <td align="right" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;">
      <?php echo number_format($veh_installment['installment_per_month'],2); ?></td>
  </tr>
    <?php
    $total = $total + $veh_installment['installment_per_month'];
    $per_count+=1;}}} ?>
  <tr>
      <td colspan="10" align="right" valign="middle" bgcolor="#FFFFFF" class="text2" style="padding-left:3px;">Total :</td>
      <td align="right" valign="middle" bgcolor="#FFFFFF" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
  </tr>
</table>