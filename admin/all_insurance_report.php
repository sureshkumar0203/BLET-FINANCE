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

if(isset($_REQUEST["action"])=="delete")
{
	$num=$db->countRows('premium_payment_details',"policy_id='$_REQUEST[id]'");
	if($num==0)
	{
		$db->deleteFromTable("lic_registration","id='$_REQUEST[id]'");
		header("Location:manage_lic.php?msg=deleted");
	}
	else
	{
		header("Location:manage_lic.php?msg=no");
		exit;
	}
}
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<!--table sorter ***************************************************** -->

	
<script type="text/javascript">
/*	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
           3: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 25});
	});
*/	</script>

<!--*******************************************************************-->

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
if(isset($_REQUEST['from_date'])){
      $frm_dt = $_REQUEST['from_date'];
    }
    else
    {
      $frm_dt = "";
    }
    if(isset($_REQUEST['to_date'])){
      $to_dt = $_REQUEST['to_date'];
    }
    else
    {
      $to_dt = "";
    }

?>
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
                          <td width="50%" align="left" valign="middle"><h2>All Insurance Report</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="hi_registration.php" class="linkButton">Add New </a></h2></td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="middle">
					<form action="all_insurance_report.php" name="frm" id="frm">
					<table width="800" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="17%" height="25" align="left" valign="middle" class="text1">Insurance Type</td>
					    <td width="23%" align="left" valign="middle" class="text1">Date from</td>
					    <td width="22%" align="left" valign="middle" class="text1">Date to</td>
					    <td width="17%" align="left" valign="middle" class="text1">Status</td>
					    <td width="21%" align="left" valign="middle">&nbsp;<input type="hidden" name="search" value="due_insurance" id="search"></td>
					    </tr>
					  <tr>
					    <td width="17%" align="left" valign="middle">
                        <select name="insurance_type" style="border:1px solid #CCC; height:25px; width:100px;">
                        <option value="LIC" <?php if(isset($_REQUEST["insurance_type"]) && $_REQUEST["insurance_type"]=="LIC") { echo "Selected"; }?>>LIC</option>
                        <option value="Mediclaim" <?php if(isset($_REQUEST["insurance_type"]) && $_REQUEST["insurance_type"]=="Mediclaim") { echo "Selected"; }?>>Mediclaim</option>
                        </select>
                        </td>
					    <td width="23%" align="left" valign="middle">
                        <input name="from_date" type="text" id="from_dt" class="datepick validate[required] textfield121" value="<?php echo $frm_dt; ?>"/></td>
					    <td width="22%" align="left" valign="middle">
                        <input name="to_date" type="text" id="to_date" class="datepickFuture validate[required] textfield121" value="<?php echo $to_dt; ?>"/></td>
					    <td width="17%" align="left" valign="middle">
                        <select name="status" style="border:1px solid #CCC; height:25px; width:100px;">
                        <option value="tobepaid" <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="tobepaid") { echo "selected"; } ?>>To be paid</option>
                        <option value="paid" <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="paid") { echo "selected"; } ?>>Paid</option>
                        <option value="both" <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="both") { echo "selected"; } ?>>Both</option>
                        </select>
                        </td>
						<td width="21%" align="left" valign="middle"><input type="image" name="imageField" src="images/searchButton.png"></td>
					  </tr>
					</table>
					</form>
					</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="1038" height="30" valign="middle" align="center">
                    <?php if(isset($_REQUEST["msg"])=="no") { ?>
                    <span class="error">You can not delete this record because some premiums are already given.</span>
                    <?php } ?>
                     <?php if(isset($_REQUEST["msg"])=="deleted") { ?>
                    <span class="error">Record deleted successfully.</span>
                    <?php } ?>
                    
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top" class="text1">
                    <?php  if(isset($_REQUEST["search"])=="due_insurance")  {  ?>
                     Insurance report from dated 
    				<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date"]));?> </font> to
    				<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date"])); ?></font>
    
					<table height="61" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
                      <thead>
                        <tr>
                          <th width="17%" height="27" align="left" valign="middle" class="fetch_headers">Policy Holder Name</th>
                          <th width="12%" align="left" valign="middle" class="fetch_headers">Policy Detail </th>
                          <th width="16%" align="right" valign="middle" class="fetch_headers"> Premium Amount</th>
                          <th width="20%" align="left" valign="middle" class="fetch_headers">
                          <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="tobepaid") { ?>Due Date <?php } ?>
                          <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="paid") { ?>Paid Date <?php } ?>
                          <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="both") { ?>Both <?php } ?>
                          </th>
                          </tr>
                      </thead>
                      <tbody>
					  <?php
					 
					  
					  if(isset($_REQUEST["insurance_type"])=="LIC") { 
						//LIC Reminder starts from here
						if(isset($_REQUEST["status"]) && $_REQUEST["status"] =="tobepaid") {
							$sql_rem="SELECT * from premium_payment_details where next_payment_date  between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]'";
						} 
						if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="paid") {
							$sql_rem="SELECT * from premium_payment_details where payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]'";
						}
						if(isset($_REQUEST["status"]) && $_REQUEST["status"]=="both") {
							$sql_rem="SELECT * from premium_payment_details where (next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]') OR (payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]')";
						}
					  }
					  
					  
					  if(isset($_REQUEST["insurance_type"])=="Mediclaim") { 
						//Mediclaim Reminder starts from here
						if(isset($_REQUEST["status"])=="tobepaid") {
							$sql_rem="SELECT * from hi_premium_payment_details where  next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]'";
						} 
						if(isset($_REQUEST["status"])=="paid") {
							$sql_rem="SELECT * from hi_premium_payment_details where payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]'";
						}
						if(isset($_REQUEST["status"])=="both") {
							$sql_rem="SELECT * from hi_premium_payment_details where (next_payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]') OR (payment_date between '$_REQUEST[from_date]' AND '$_REQUEST[to_date]')";
						}
					  }
					  	// echo $sql_rem;
						$src_row=$db->mysqli->query($sql_rem);
						$num=$src_row->num_rows;
						?>
                        <?php
						 while($src_res=$src_row->fetch_assoc())
						 {
							 if($_REQUEST['insurance_type']=="LIC") { 
							 	$detail=$db->fetchSingle("lic_registration","id='$src_res[policy_id]'"); 
								$ph_name=$detail['name_policy_holder'];
								$policy_no=$detail['policy_no'];
								$agent_name=$detail['name_agent'];
								$agent_contact_no=$detail['agent_contact_no'];
								$policy_branch=$detail['policy_branch'];
								
                // $premium_amount=$src_res['premium_amount']." ".$src_res['premium_mode'];
								$premium_amount=$src_res['total_premium_amount'];
								$due_date=$src_res['next_payment_date'];
								$paid_date=$src_res['payment_date'];
							 }
							 if($_REQUEST['insurance_type']=="Mediclaim") { 
							 	$detail=$db->fetchSingle("mediclaim_registration","id='$src_res[policy_id]'"); 
								$ph_name=$detail['policy_holder_name'];
								$policy_no=$detail['policy_no'];
								$idcard_no=$detail['idcard_no'];
								
								$premium_amount=$src_res['total_premium_amount'];
								
								$due_date=$src_res['next_payment_date'];
								$paid_date=$src_res['payment_date'];
							 }
							 
			            ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td height="30" align="left" class="fetch_contents" style="padding-left:3px;"><?php echo strtoupper($ph_name); ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
                          <span class="level_msg">Policy No. : </span><br>
						  <?php echo strtoupper($policy_no)."<br>";  ?>
                          
                           <?php if(isset($idcard_no) && $idcard_no!="") {  ?> 
						  <span class="level_msg">ID Card No. : </span><br> 
						  <?php echo strtoupper($idcard_no)."<br>"; } ?>
                          
                          
						  <?php if($agent_name!="") {  ?> 
						  <span class="level_msg">Agent Name / Contact No. : </span><br> 
						  <?php echo strtoupper($agent_name)." / ".strtoupper($agent_contact_no)."<br>"; } ?>
                          
                          <?php if($policy_branch!="") {  ?> 
						  <span class="level_msg">Policy Branch : </span><br> <?php echo strtoupper($policy_branch); } ?>
                          
                          </td>
                          <td align="right" valign="middle" class="fetch_contents" style="padding-left:3px;"><?php echo $premium_amount; ?></td>
                          <td align="left" class="fetch_contents" style="padding-left:3px;">
						  <?php if(isset($_REQUEST['status']) && $_REQUEST['status']=="tobepaid") { ?><?php echo date("jS M,Y",strtotime($due_date)); ?><?php } ?>
                          <?php if(isset($_REQUEST['status']) && $_REQUEST['status']=="paid") { ?> <?php echo date("jS M,Y",strtotime($paid_date)); ?><?php } ?>
                          <?php if(isset($_REQUEST['status']) && $_REQUEST['status']=="both") { ?>
                          <span class="level_msg">Paid Date : </span><br> <?php echo date("jS M,Y",strtotime($paid_date))."<br>"; ?>
                          <span class="level_msg">Due Date : </span><br> <?php echo date("jS M,Y",strtotime($due_date)); ?>
                          <?php } ?>
                          
                          
						  </td>
                          </tr>
                        <?php } ?>
                        
                       <?php if($num==0) { ?>
                        <tr>
                          <td colspan="8" align="center" class="noRecords2"><font color="#FF0000">No Records Found !!!!</font></td>
                        </tr>
					  <?php } ?>
                      </tbody>
                    </table>
                    <?php } ?>
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
                    <td align="right">
					<table width="94%" border="0" cellpadding="0" cellspacing="0" align="center">
                      <tr>
                        <td width="76%" align="center">&nbsp;</td>
                        <td width="24%" >
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
