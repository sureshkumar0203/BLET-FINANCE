<?php
ob_start();
//session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//Object initialization
//$dbf = new User();

if(isset($_REQUEST["yr"]) != ''){
  $yr = $_REQUEST["yr"];
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
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table2" width="100%">
  <thead>
        <tr>
            <th width="7%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
            <th width="13%" align="left" valign="middle" class="fetch_headers">Name</th>
            <th width="11%" align="right" valign="middle" class="fetch_headers">Premium Amount</th>
            <th width="13%" align="left" valign="middle" class="fetch_headers">Policy Number</th>
            <th width="12%" align="left" valign="middle" class="fetch_headers">Maturity Date</th>
            <th width="13%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
            <th width="13%" align="center" valign="middle" class="fetch_headers">Premium <br>
            Mode</th>
            <th width="18%" align="right" valign="middle" class="fetch_headers">Premium <br />
        	Amount</th>
        </tr>
  </thead>
      <?php
        $start_date=$_REQUEST['start_date'];
        $end_date=$_REQUEST['end_date'];
        $per_count = 1;
        $total = 0;
        $string = "select * from premium_payment_details where (next_payment_date between '$start_date' And '$end_date') And status='0'";
        $lic_premium = $db->mysqli->query($string);							
        while($premium_information=$lic_premium->fetch_assoc()) {								
        $premium_name_unpaid = $db->fetchSingle("lic_registration","id='$premium_information[policy_id]'");
        ?>
      <tr>
        <td align="center" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
        <td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($premium_name_unpaid['name_policy_holder']); ?></td>
        <td align="right" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $premium_name_unpaid['premium_amount']; ?></td>
        <td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><span class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($premium_name_unpaid['policy_no']);?></span></td>
        <td align="left" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php echo $premium_name_unpaid['date_maturity']; ?></td>
        <td align="left" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><span class="fetch_contents" style="padding-left:3px;">
          <?php  echo date("jS M,Y",strtotime($premium_information['next_payment_date']));?>
        </span></td>
        <td align="center" valign="middle" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><?php  echo $premium_information['premium_mode'];?></td>
        <td align="right" bgcolor="#FFFFFF" class="fetch_contents" style="padding-left:3px;"><span class="fetch_contents" style="padding-left:3px;"><?php echo number_format($premium_information['premium_amount'],2);?></span></td>
</tr>
<?php $total = $total + $premium_information['premium_amount'];
$per_count+=1;} ?>
       <tr>
          <td colspan="7" align="right" valign="middle" bgcolor="#FFFFFF" class="text2" style="padding-left:3px;">Total :</td>
          <td align="right" valign="middle" bgcolor="#FFFFFF" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
  </tr>
</table>