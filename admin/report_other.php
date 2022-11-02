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
$start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] :"";
$end_date = isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] :"";
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
                          <td width="50%" align="left" valign="middle"><h2>All Other Report</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="admin_home.php" class="linkButton">Cancel </a></h2></td>
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
                    <td width="10">&nbsp;</td>
                    <td height="35" align="left" valign="middle">
                    <form name="frm" id="frm">
                    <table width="40%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="23%" align="left"><input name="start_date" type="text" id="start_date" class="textfield121d" readonly value="<?= isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] :'' ;?>"/></td>
                        <td width="34%" align="left" valign="middle"><input name="end_date" type="text" id="end_date" class="textfield121d" readonly value="<?= isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] :'';?>"/></td>
                        <td width="19%" align="left" valign="middle"></td>
                        <td width="24%" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%" align="center" valign="middle"><input type="image" name="imageField" src="images/searchButton.png" /></td>
                            <td width="50%" align="center" valign="middle"><a href="report_other_full.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="images/xls.png" width="16" height="16" border="0" /></a></td>
                          </tr>
                        </table></td>
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
                            <td width="88%" height="22" align="center" valign="middle" bgcolor="#D7F2FF" class="text2">Other Expenses paid list in <?php echo $start_date!="" ? date('d-m-Y', strtotime($start_date))." to " : "" ;?><?php echo $end_date!='' ? date('d-m-Y', strtotime($end_date)):'';?></td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                          <thead>
                            <tr>
                              <th width="5%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                              <th width="12%" align="left" valign="middle" class="fetch_headers">Firm Name.</th>
                              <th width="18%" align="left" valign="middle" class="fetch_headers">Payment Head</th>
                              <th width="19%" align="left" valign="middle" class="fetch_headers">Paid To</th>
                              <th width="11%" align="left" valign="middle" class="fetch_headers">Paid Date</th>
                              <th width="19%" align="left" valign="middle" class="fetch_headers">Due Date</th>
                              <th width="16%" align="right" valign="middle" class="fetch_headers">Installment Amount</th>
                              </tr>
                            </thead>
                            <?php
							$per_count = 1;
							$total = 0;
							if($start_date!='' && $end_date!=''){
                $string = "select * from other_details where payment_date between '".$start_date."' and '".$end_date."'";
              }
              else{
  							$string = "select * from other_details";
              }
              // echo $string;
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
                              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo date("d-m-Y",strtotime($vehicle_info["payment_date"]));?></td>
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
                              <td colspan="6" align="right" valign="middle" class="text2" style="padding-left:3px;">Total :</td>
                              <td align="right" valign="middle" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
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
