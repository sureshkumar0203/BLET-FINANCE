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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>All Lic Report</h2></td>
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
                        <td width="23%" align="left">
                          <input name="start_date" type="text" id="start_date" class="textfield121d" readonly value="<?php echo isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : '' ;?>"/>
                        </td>
                        <td width="30%" align="left" valign="middle">
                       <input name="end_date" type="text" id="end_date" class="textfield121d" readonly value="<?php echo isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : '' ;?>"/></td>
                        <td width="22%" align="center" valign="middle"><input type="image" name="imageField" src="images/searchButton.png" /></td>
                        <td width="25%" align="center" valign="middle">&nbsp;</td>
                      </tr>
                    </table>
                    </form>
                    </td>
                    <td width="12">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="bottom">
                        <table width="70%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#006699">
                          <tr>
                            <td width="88%" align="center" valign="middle" bgcolor="#D7F2FF" class="text2">List of LIC Holder's completed Premium from <?php echo isset($_REQUEST["start_date"]) ? $_REQUEST['start_date'] :'';?> to <?php echo isset($_REQUEST["end_date"]) ? $_REQUEST['end_date'] :'';?></td>
                            <td width="12%" height="22" align="center" valign="middle" bgcolor="#990000" ><a href="report_lic_csv.php?start_date=<?php echo $_REQUEST["start_date"];?>&end_date=<?php echo $_REQUEST["end_date"];?>"><img src="images/xls.png" width="16" height="16" border="0" /></a></td>
                          </tr>
                        </table>
                        <table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                          <thead>
                            <tr>
                              <th width="8%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                              <th width="20%" align="left" valign="middle" class="fetch_headers">Name</th>
                              <th width="15%" align="right" valign="middle" class="fetch_headers">Premium Amount</th>
                              <th width="15%" align="left" valign="middle" class="fetch_headers">Policy No.</th>
                              <th width="14%" align="left" valign="middle" class="fetch_headers">Maturity Date</th>
                              <th width="14%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
                              <th width="16%" align="center" valign="middle" class="fetch_headers">Premium
Mode</th>
                              <th width="13%" align="right" valign="middle" class="fetch_headers">Premium
Amount</th>
                              </tr>
                            </thead>
                            <?php
							$start_date=isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] :'';
							$end_date=isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] :'';
							$per_count = 1;
							$total = 0;
							$string = "select * from premium_payment_details where status=1 and (payment_date between '$start_date' and '$end_date')";
              // echo $string;
							$lic_premium = $db->mysqli->query($string);							
                            while($premium_info=$lic_premium->fetch_assoc()) {								
								$premium_name = $db->fetchSingle("lic_registration","id='$premium_info[policy_id]'");
								?>
                            <tr>
                              <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($premium_name['name_policy_holder']);?></td>
                              <td align="right" class="fetch_contents" style="padding-left:3px;"><?php echo $premium_name['premium_amount'];?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($premium_name['policy_no']);?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $premium_name['date_maturity'];?></td>
                              <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo date("d/m/Y",strtotime($premium_info['payment_date']));?></td>
                              <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo$premium_info['premium_mode'];?></td>
                              <td align="right" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($premium_info['premium_amount'],2);?></td>
                              </tr>
                            <?php 
							$total = $total + $premium_info['premium_amount'];
							$per_count+=1;} ?>
                           <tr>
                              <td colspan="7" align="right" valign="middle" class="text2" style="padding-left:3px;">Total :</td>
                              <td align="right" valign="middle" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
                            </tr>
                           
                          </table>
                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="35" align="left" valign="bottom">
                            <table width="70%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#993300">
                          <tr>
                            <td width="88%" align="center" valign="middle" bgcolor="#FFE1E1" class="noRecords2">List of LIC Holder's not completed Premium from <?php echo isset($_REQUEST["start_date"]) ? $_REQUEST['start_date'] :'' ;?> to <?php echo isset($_REQUEST["end_date"]) ? $_REQUEST['end_date'] :'';?></td>
                            <td width="12%" height="22" align="center" valign="middle" bgcolor="#660066" ><a href="report_lic_pending_csv.php?start_date=<?php echo isset($_REQUEST["start_date"]);?>&end_date=<?php echo isset($_REQUEST["end_date"]);?>"><img src="images/xls.png" width="16" height="16" border="0" /></a></td>
                          </tr>
                        </table>
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table2" width="100%">
                              <thead>
                                <tr>
                                  <th width="5%" height="27" align="center" valign="middle" class="fetch_headers">SL.</th>
                                  <th width="16%" align="left" valign="middle" class="fetch_headers">Name</th>
                                  <th width="15%" align="right" valign="middle" class="fetch_headers">Premium Amount</th>
                                  <th width="13%" align="left" valign="middle" class="fetch_headers">Policy No.</th>
                                  <th width="11%" align="left" valign="middle" class="fetch_headers">Maturity Date</th>
                                  <th width="12%" align="left" valign="middle" class="fetch_headers">Payment Date</th>
                                  <th width="13%" align="center" valign="middle" class="fetch_headers">Premium
                                    Mode</th>
                                  <th width="15%" align="right" valign="middle" class="fetch_headers">Premium
Amount</th>
                                </tr>
                              </thead>
                              <?php
								$start_date=isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] :'';
                $end_date=isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] :'';
								$per_count = 1;
								$total = 0;
								$string = "select * from premium_payment_details where status='0' and (next_payment_date between '$start_date' And '$end_date')";
								$lic_premium = $db->mysqli->query($string);							
								while($premium_information=$lic_premium->fetch_assoc()) {								
								$premium_name_unpaid = $db->fetchSingle("lic_registration","id='$premium_information[policy_id]'");
								?>
                              <tr>
                                <td align="center" class="fetch_contents" style="padding-left:3px;"><?php echo $per_count; ?></td>
                                <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($premium_name_unpaid['name_policy_holder']); ?></td>
                                <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo $premium_name_unpaid['premium_amount']; ?></td>
                                <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($premium_name_unpaid['policy_no']);?></td>
                                <td align="left" class="fetch_contents" style="padding-left:3px;"><?php echo $premium_name_unpaid['date_maturity']; ?></td>
                                <td align="left" valign="middle" class="fetch_contents" style="padding-left:3px;">
                                  <?php  echo date("d/m/Y",strtotime($premium_information['next_payment_date']));?></td>
                                <td align="center" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php  echo $premium_information['premium_mode'];?></td>
                                <td align="right" class="fetch_contents" style="padding-left:3px;"><?php echo number_format($premium_information['premium_amount'],2);?></td>
                              </tr>
                              <?php $total = $total + $premium_information['premium_amount'];
							  $per_count+=1;} ?>
                             <tr>
                              <td colspan="7" align="right" valign="middle" class="text2" style="padding-left:3px;">Total :</td>
                              <td align="right" valign="middle" class="noRecords2" style="padding-left:3px;">&nbsp;<?php if($total >0){ echo number_format($total,2); }?></td>
                            </tr>
                            </table></td>
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
