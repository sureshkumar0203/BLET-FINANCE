<?php
ob_start();
//session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();

//Object initialization
//$dbf = new User();

$start_date = $_REQUEST["start_date"];
$end_date = $_REQUEST["end_date"];
?>
<style>
.text2{font-family:Arial, Helvetica, sans-serif;font-size:11px;color:#0C8EBA;font-weight:bold;} 
.fetch_headers {font-family:Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color:#000000;border-bottom:solid 1px #ACACAC;white-space:nowrap;padding-left:5px;}
.fetch_contents {font-family:Arial, Helvetica, sans-serif;font-size: 12px;color:#000000;border-bottom:solid 1px #ACACAC;white-space:nowrap;padding-left:5px;}
</style>
<body>
Other Expenses paid list in <?php echo date('d-m-Y', strtotime($start_date));?> to <?php echo date('d-m-Y', strtotime($end_date));?>
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
  <thead>
    <tr>
      <th width="5%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
      <th width="19%" align="left" valign="middle" class="fetch_headers">Firm Name.</th>
      <th width="24%" align="left" valign="middle" class="fetch_headers">Payment Head</th>
      <th width="18%" align="left" valign="middle" class="fetch_headers">Paid To</th>
      <th width="23%" align="left" valign="middle" class="fetch_headers">Due Date</th>
      <th width="11%" align="right" valign="middle" class="fetch_headers">Installment Amount</th>
      </tr>
    </thead>
    <?php
    $per_count = 1;
    $total = 0;
    
    $string = "select * from other_details where (payment_date between '$start_date' And '$end_date')";
    $inst_peri_row = $db->mysqli->query($string);
    while($vehicle_info=$inst_peri_row->fetch_assoc()) {
        $firm = $db->getDataFromTable("firms", "firm_name", "id='$vehicle_info[firm_id]'");
        $head = $db->getDataFromTable("payment_heads", "heads", "id='$vehicle_info[payment_head_id]'");
    ?>
    <tr>
      <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
      <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($firm);?></td>
      <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $head;  ?></td>
      <td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo $vehicle_info["paid_to"];?></td>
      <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("d-m-Y",strtotime($vehicle_info["date_from"]));?> to <?php echo date("d-m-Y",strtotime($vehicle_info["date_to"]));?></td>
      <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;">
      <?php echo number_format($vehicle_info['amount'],2); ?></td>
      </tr>
    <?php
    $total = $total + $vehicle_info['amount'];
    $per_count+=1;
    }
    ?>
    <tr>
      <td colspan="5" align="right" valign="middle" class="text2" style="padding-left:3px;">Total :</td>
      <td align="right" valign="middle" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
    </tr>
</table>
</body>
</html>
