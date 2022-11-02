<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$year_start_date = $_REQUEST["start_date"];
$year_end_date = $_REQUEST["end_date"];
?>
<style>
.fetch_headers {font-family:Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color:#000000;border-bottom:solid 1px #ACACAC;white-space:nowrap;padding-left:5px;}
table.tablesorter {font-family:arial;background-color: #CDCDCD;margin-top:10px;font-size: 12px;width:100%;border-collapse:collapse;text-align: left;}
/*change this coolor for header*/
table.tablesorter thead tr th, table.tablesorter tfoot tr th {background-color:#ccc;font-size: 11px;padding: 2px;font-weight:bold;color:#000;}
table.tablesorter thead tr .header {background-image: url(bg.gif);background-repeat: no-repeat;background-position: center right;cursor: pointer;}
table.tablesorter tbody td {color: #000000;	padding: 4px;	background-color: #FFF;	vertical-align: middle;	font-size:11px;}
</style>
<?php						
foreach($dbf->fetchOrder('rto_office',"id='$_REQUEST[rto_office]'","") as $allrto){
	
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
<td align="center" bgcolor="#FFFFFF" class="fetch_contents"><?php echo $per_count; ?></td>
<td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($vehicle_info['display_no']);?></td>                        
<td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo date("jS M,Y",strtotime($vehicle_info[date_of_payment])); ?></td>
<td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($firm[firm_name]); ?></td>
<td align="left" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($rto[rto_name]); ?></td>
<td align="right" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[tax_amount],2); ?></td>
<td align="right" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[fine],2); ?></td>
<td align="right" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($vehicle_info[total],2); ?></td>
</tr>
<?php
$total = $total + $vehicle_info['tax_amount'];
$per_count+=1;}} ?>
<tr>
  <td colspan="7" align="right" valign="middle" bgcolor="#FFFFFF" class="text2" style="padding-left:3px;">Total :</td>
  <td align="right" valign="middle" bgcolor="#FFFFFF" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
</tr>
</table>
<?php
	}							
}
?>