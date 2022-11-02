<?php
ob_start();
error_reporting(1);
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
$pageTitle='DASHBOARD';
include 'application_top.php';
//Object initialization

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
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td align="left" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="10" colspan="3" align="left" valign="top"></td>
            </tr>
          <tr>
            <td width="226" align="left" valign="top" height="365"><?php include 'left.php';?></td>
            <td width="10">&nbsp;</td>
            <td align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top">
				
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="7" colspan="3"></td>
                  </tr>
                  <?php
                    // Finance 
                     $count=1;
                     $sql="SELECT f.*,i.* FROM finance_details f  Inner join installment_details i on f.vehicle_id=i.vehi_id where next_payment_date between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval f.alert_finance day) AND i.payment_status='Unpaid' group by f.vehicle_id order by i.next_payment_date";
                      $sql_row=$db->mysqli->query($sql);
                      $num=$sql_row->num_rows;
                      if($num!=0) { 
                  ?>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center" valign="middle" class="white_heading" height="35" bgcolor="#FFFFFF"><font color="#003399">FINANCE</font></td>
                    <td>&nbsp;</td>
                  </tr>
                 
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top" height="35">
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tablesorter" style="border-collapse:collapse;box-shadow: 5px 3px 3px #ccc;">
                    <thead>
                      <tr bgcolor="#999999" class="text1">
                        <th width="2%" align="center">SL</th>
                        <th width="9%" height="30" style="padding-left:5px;">Vehicle No.</th>
                        <th width="10%" height="30" style="padding-left:5px;">Vehicle Type</th>
                        <th width="15%" height="30" style="padding-left:5px;">Firm Name</th>
                        <th width="14%" height="30" style="padding-left:5px;">Due Date</th>
                        <th width="9%" height="30" style="padding-left:5px;">Finance By</th>
                        <th width="10%" height="30" style="padding-left:5px;">Payment Bank</th>
                        <th width="18%" height="30" style="padding-left:5px;">Loan A/C No.</th>
                        <th width="13%" height="30" style="padding-left:5px;">Installment Amount</th>
                      </tr>
                      </thead>
                       <?php
                       $finance_total=0;
                       while($val_inst=$sql_row->fetch_assoc()) { 
                       
                       $veh_info=$db->fetchSingle("vehicle_registration","id='$val_inst[vehi_id]'");
                       //Vehicle Type : Crane , Truck
                        $veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");
						//echo $val_inst[finance_id];
						$firm=$db->fetchSingle("firms","id='$veh_info[firm_name]'"); 
                       ?>
                      <tr>
                        <td align="center"><?php echo $count; ?></td>
                        <td style="padding-left:5px;">
                        <a href="add_all_other_info.php?id=<?php echo $veh_info["id"];?>&#tabs-1" class="linktext"><?php  echo strtoupper($veh_info["display_no"]);  ?></a></td>
                        
                        <td style="padding-left:5px;"><?php echo strtoupper($veh_type["vtype"]); ?></td>
                        <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
                        <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_inst["next_payment_date"])); ?></td>
                        <td style="padding-left:5px;"><?php echo strtoupper($val_inst["finance_by"]); ?></td>
                        <td style="padding-left:5px;"><?php echo strtoupper($val_inst["payment_bank"]); ?></td>
                        <td style="padding-left:5px;"><?php echo strtoupper($val_inst["loan_ac_no"]); ?></td>
                        <td style="padding-left:5px;">Rs. <?php echo $val_inst["installment_per_month"]; ?></td>
                      </tr>
                      <?php 
                      $finance_total=$finance_total+$val_inst["installment_per_month"];
                      $count+=1; } 
                      ?>
                  
                  
                       <?php //if($num==0) { ?>
                      <tr>
                        <td height="25" colspan="9" align="right" class="error" style="padding-right:70px;">Total = Rs. <?php echo $finance_total; ?></td>
                        </tr>
                       <?php //} ?>
                    </table>
                  
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                   <?php } ?>
                
                
                  <?php
                  //Insurance Reminder starts from here
                   $ins_count=1;
                   $sql_ins_rem="SELECT * from insurance_details where insurance_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_insurance day) order by insurance_to_dt";
                   $sql_ins_rem_row=$db->mysqli->query($sql_ins_rem);
                   $ins_num=$sql_ins_rem_row->num_rows;
                   if($ins_num!=0) { 
                  ?>                    
                   <tr>
                    <td width="10">&nbsp;</td>
                    <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">INSURANCE</font></td>
                    </tr> 
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tablesorter" style="border-collapse:collapse;box-shadow: 5px 3px 3px #999;">
                        <thead>
                          <tr bgcolor="#999999" class="text1">
                            <th width="3%" align="center">SL</th>
                            <th width="10%" height="30" style="padding-left:5px;">Vehicle No.</th>
                            <th width="11%" style="padding-left:5px;">Vehicle Type</th>
                            <th width="17%" height="30" style="padding-left:5px;">Firm Name </th>
                            <th width="16%" height="30" style="padding-left:5px;">Due Date</th>
                            <th width="23%" style="padding-left:5px;">Insurance Company</th>
                            <th width="20%" style="padding-left:5px;">Amount</th>
                          </tr>
                          </thead>
                           <?php
                           $ins_tot=0;
                           while($val_ins=$sql_ins_rem_row->fetch_assoc()) {
                            $veh_info_ins=$db->fetchSingle("vehicle_registration","id='$val_ins[vehicle_id]'");
                           //Vehicle Type : Crane , Truck
                            $veh_type_ins=$db->fetchSingle("vehicle_types","id='$veh_info_ins[vehicle_type]'");
                            $firm = $db->strRecordID("firms", "*", "id='$veh_info_ins[firm_name]'");
                           ?>
                          <tr>
                            <td align="center"><?php echo $ins_count; ?></td>
                            <td style="padding-left:5px;">
                            <a href="add_all_other_info.php?id=<?php echo $veh_info_ins["id"];?>&#tabs-2" class="linktext"><?php  echo strtoupper($veh_info_ins["display_no"]);  ?></a></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($veh_type_ins["vtype"]); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_ins["insurance_to_dt"])); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($val_ins["insurance_company_name"]); ?></td>
                            <td style="padding-left:5px;">Rs. <?php echo $val_ins["total"]; ?></td>
                          </tr>
                          <?php 
                          $ins_tot=$ins_tot+$val_ins["total"];
                          $ins_count+=1;
                          } 
                          ?>
                           <?php //if($ins_num==0) { ?>
                          <tr>
                            <td height="25" colspan="7" align="right" class="error" style="padding-right:150px;">Total = Rs. <?php echo $ins_tot; ?></td>
                            </tr>
                           <?php //} ?>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>
                      <?php } ?>
                      
                      
                        <?php
                        //Road tax reminder starts here
                        $tax_count=1;
                       $sql_tax_rem="SELECT * from roadtax_details where tax_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_tax day) order by tax_to_dt";
                       $sql_tax_rem_row=$db->mysqli->query($sql_tax_rem);
                       $tax_num=$sql_tax_rem_row->num_rows;
                       if($tax_num!=0) { 
                      ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">ROAD TAX</font></td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                          <tr bgcolor="#999999" class="text1">
                            <td width="3%" align="center">SL</td>
                            <td width="10%" height="30" style="padding-left:5px;">Vehicle No.</td>
                            <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                            <td width="17%" height="30" style="padding-left:5px;">Firm Name</td>
                            <td width="16%" height="30" style="padding-left:5px;">Due Date</td>
                            <td width="23%" style="padding-left:5px;">RTO Office</td>
                            <td width="" style="padding-left:5px;">Amount</td>
                          </tr>
                           <?php
                           $road_tax_tot=0;
                           while($val_tax=$sql_tax_rem_row->fetch_assoc()) {
                            $veh_info_tax=$db->fetchSingle("vehicle_registration","id='$val_tax[vehicle_id]'");
                            $firm = $db->strRecordID("firms", "*", "id='$veh_info_tax[firm_name]'");
                            //Vehicle Type : Crane , Truck
                            $veh_type_tax=$db->fetchSingle("vehicle_types","id='$veh_info_tax[vehicle_type]'"); 
                            $rto = $db->strRecordID("rto_office" , "*", "id='$val_tax[rto_office]'");
                           ?>
                          <tr>
                            <td align="center"><?php echo $tax_count; ?></td>
                            <td style="padding-left:5px;">
                            <a href="add_all_other_info.php?id=<?php echo $veh_info_tax["id"];?>&#tabs-3" class="linktext"><?php  echo strtoupper($veh_info_tax["display_no"]);  ?></a></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($veh_type_tax["vtype"]); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?></td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
                            <td style="padding-left:5px;">Rs. <?php echo $val_tax["total"]; ?></td>
                          </tr>
                          <?php 
                          $road_tax_tot=$road_tax_tot+$val_tax["total"];
                          $tax_count+=1;} ?>
                           <?php //if($tax_num==0) { ?>
                          <tr>
                            <td height="25" colspan="7" align="right" class="error" style="padding-right:143px;">Total = Rs. <?php echo $road_tax_tot; ?></td>
                            </tr>
                           <?php //} ?>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>
                      <?php } ?>
                      <?php
                        //Fitness reminder starts here
                        $fit_count=1;
                        $sql_fit_rem="SELECT * from  fitness_details where fitness_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_fitness day) order by fitness_to_dt";
                       $sql_fit_rem_row=$db->mysqli->query($sql_fit_rem);
                       $fit_num=$sql_fit_rem_row->num_rows;
                       if($fit_num!=0) { 
                      ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">FITNESS</font></td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                          <tr bgcolor="#999999" class="text1">
                            <td width="3%" align="center">SL</td>
                            <td width="10%" height="30" style="padding-left:5px;">Vehicle No.</td>
                            <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                            <td width="17%" height="30" style="padding-left:5px;">Firm Name</td>
                            <td width="16%" height="30" style="padding-left:5px;">Due Date</td>
                            <td width="23%" style="padding-left:5px;">RTO Office</td>
                            <td width="" style="padding-left:5px;">Amount</td>
                          </tr>
                           <?php
                           $fitness_total=0;
                           while($val_fit=$sql_fit_rem_row->fetch_assoc()) {
                            $veh_info_fit=$db->fetchSingle("vehicle_registration","id='$val_fit[vehicle_id]'");
                            $firm = $db->strRecordID("firms", "*", "id='$veh_info_fit[firm_name]'");
                           //Vehicle Type : Crane , Truck
                            $veh_type_fit=$db->fetchSingle("vehicle_types","id='$veh_info_fit[vehicle_type]'"); 
                            $rto = $db->strRecordID("rto_office" , "*", "id='$veh_info_fit[rto_office]'");
                           ?>
                          <tr>
                            <td align="center"><?php echo $fit_count; ?></td>
                            <td style="padding-left:5px;">
                            <a href="add_all_other_info.php?id=<?php echo $veh_info_fit[id];?>&#tabs-4" class="linktext"><?php  echo strtoupper($veh_info_fit["display_no"]);  ?></a></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($veh_type_fit["vtype"]); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?></td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_fit["fitness_to_dt"])); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
                            <td style="padding-left:5px;">Rs. <?php echo $val_fit["fitness_amount"]; ?></td>
                          </tr>
                          <?php 
                          $fitness_total=$fitness_total+$val_fit["fitness_amount"];
                          $fit_count+=1;} ?>
                           <?php //if($fit_num==0) { ?>
                          <tr>
                            <td height="25" colspan="7" align="right" style="padding-right:155px;" class="error">Total = Rs. <?php echo $fitness_total; ?></td>
                            </tr>
                           <?php //} ?>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>  
                      <?php } ?>
                       <?php
                        //Permit reminder starts here
                        $per_count=1;
                        $sql_per_rem="SELECT * from  permit_details where permit_to_dt between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_permit day) order by permit_to_dt";
                       $sql_per_rem_row=$db->mysqli->query($sql_per_rem);
                       $per_num=$sql_per_rem_row->num_rows;
                       if($per_num!=0) { 
                      ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">PERMIT</font></td>
                        <td>&nbsp;</td>
                      </tr>  
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                          <tr bgcolor="#999999" class="text1">
                            <td width="3%" align="center">SL</td>
                            <td width="10%" height="30" style="padding-left:5px;">Vehicle No.</td>
                            <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                            <td width="17%" height="30" style="padding-left:5px;">Firm Name</td>
                            <td width="16%" height="30" style="padding-left:5px;">Due Date</td>
                            <td width="23%" style="padding-left:5px;">RTO Office</td>
                            <td width="" style="padding-left:5px;">Amount</td>
                          </tr>
                           <?php
                           $permit_total=0;
                           while($val_per=$sql_per_rem_row->fetch_assoc()) {
                            $veh_info_per=$db->fetchSingle("vehicle_registration","id='$val_per[vehicle_id]'");
                            $firm = $db->strRecordID("firms", "*", "id='$veh_info_per[firm_name]'");
                           //Vehicle Type : Crane , Truck
                            $veh_type_per=$db->fetchSingle("vehicle_types","id='$veh_info_per[vehicle_type]'"); 
                            $rto = $db->strRecordID("rto_office" , "*", "id='$val_per[rto_office]'");
                           ?>
                          <tr>
                            <td align="center"><?php echo $per_count; ?></td>
                            <td style="padding-left:5px;">
                            <a href="add_all_other_info.php?id=<?php echo $veh_info_per["id"];?>&#tabs-5" class="linktext"><?php  echo strtoupper($veh_info_per["display_no"]);  ?></a></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($veh_type_per["vtype"]); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?></td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_per["permit_to_dt"])); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
                            <td style="padding-left:5px;">Rs. <?php echo $val_per["permit_amount"]; ?></td>
                          </tr>
                          <?php 
                          $permit_total=$permit_total+$val_per["permit_amount"];
                          $per_count+=1;} ?>
                           <?php //if($per_num==0) { ?>
                          <tr>
                            <td height="25" colspan="7" align="right" class="error" style="padding-right:155px;">Total = Rs. <?php echo $permit_total; ?></td>
                            </tr>
                           <?php //} ?>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>  
                      <?php } ?>
                      <?php
                        //DL reminder starts here
                        $dl_count=1;
                        $sql_dl_rem="SELECT * from  driving_licence where 	valid_till between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_licence day) order by valid_till";
                        $sql_dl_rem_row=$db->mysqli->query($sql_dl_rem);
                        $dl_num=$sql_dl_rem_row->num_rows;
                        if($dl_num!=0) { 
                      ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">DL</font></td>
                        <td>&nbsp;</td>
                      </tr>  
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                          <tr bgcolor="#999999" class="text1">
                            <td width="3%" align="center">SL</td>
                            <td width="21%" height="30" style="padding-left:5px;">Driver Name </td>
                            <td width="13%" style="padding-left:5px;">Contact No.</td>
                            <td width="21%" height="30" style="padding-left:5px;">DL NO.</td>
                            <td width="13%" height="30" style="padding-left:5px;">Expire Date</td>
                            <td width="13%" style="padding-left:5px;">Referred by</td>
                            <td width="" style="padding-left:5px;">Referer Mobile No</td>
                          </tr>
                           <?php
                           while($val_dl=$sql_dl_rem_row->fetch_assoc()) {
                           ?>
                          <tr>
                            <td align="center"><?php echo $dl_count; ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($val_dl["first_name"]." ".$val_dl["middle_name"]." ".$val_dl["last_name"]); ?></td>
                            <td style="padding-left:5px;"><?php echo $val_dl["contact_no"]; ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($val_dl["dl_no"]); ?></td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_dl["valid_till"])); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($val_dl["referred_by"]); ?></td>
                            <td style="padding-left:5px;"><?php echo $val_dl["referer_mob_no"]; ?></td>
                          </tr>
                          <?php $dl_count+=1;} ?>
                           <?php if($dl_num==0) { ?>
                          <tr>
                            <td height="25" colspan="7" align="center" class="error">No Reminder Available.</td>
                            </tr>
                           <?php } ?>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>  
                      <?php } ?>  
                      <!--LIC Premiums-->
                       <?php
                       $pre_count=1;
                       $sql_pre_rem="SELECT * from premium_payment_details where next_payment_date between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_lic day) order by next_payment_date";
                       $sql_pre_rem_row=$db->mysqli->query($sql_pre_rem);
                       $pre_num=$sql_pre_rem_row->num_rows;
                       if($pre_num!=0) { 
                      ?>
                        
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">LIC PREMIUMS</font></td>
                      </tr> 
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                          <tr bgcolor="#999999" class="text1">
                            <td width="3%" align="center">SL</td>
                            <td width="10%" height="30" style="padding-left:5px;">Name</td>
                            <td width="11%" style="padding-left:5px;">Policy No.</td>
                            <td width="17%" height="30" style="padding-left:5px;">Agent Name </td>
                            <td width="16%" height="30" style="padding-left:5px;">Agent Contact No.</td>
                            <td width="23%" style="padding-left:5px;">Due Date</td>
                            <td width="20%" style="padding-left:5px;">Amount</td>
                          </tr>
                           <?php
                           $pre_tot=0;
                           while($val_premium=$sql_pre_rem_row->fetch_assoc()) {
                            $premium_info=$db->fetchSingle("lic_registration","id='$val_premium[policy_id]'");
                           ?>
                          <tr>
                            <td align="center"><?php echo $pre_count; ?></td>
                            <td style="padding-left:5px;">
                            <a href="add_premiums.php?id=<?php echo $premium_info[id];?>" class="linktext"><?php echo strtoupper($premium_info[name_policy_holder]); ?></a></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($premium_info["policy_no"]); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($premium_info["name_agent"]); ?></td>
                            <td style="padding-left:5px;"><?php echo $premium_info["agent_contact_no"]; ?></td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_premium["next_payment_date"])); ?></td>
                            <td style="padding-left:5px;">Rs. <?php echo $val_premium["premium_amount"]; ?></td>
                          </tr>
                          <?php 
                          $pre_tot=$pre_tot+$val_premium["premium_amount"];
                          $pre_count+=1;
                          } 
                          ?>      
                          <tr>
                            <td height="25" colspan="7" align="right" class="error" style="padding-right:155px;">Total = Rs. <?php echo $pre_tot; ?></td>
                            </tr>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>
                      <?php } ?>
                      
                     <!-- Health Insurance Premium-->
                       <?php
                       $hi_pre_count=1;
                       $sql_hi_pre_rem="SELECT * from hi_premium_payment_details where next_payment_date between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_med day) order by next_payment_date";
                       $sql_hi_pre_rem_row=$db->mysqli->query($sql_hi_pre_rem);
                       $hi_pre_num=$sql_hi_pre_rem_row->num_rows;
                       if($hi_pre_num!=0) { 
                      ?>    
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">HEALTH INSURANCE PREMIUMS</font></td>
                      </tr> 
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                          <tr bgcolor="#999999" class="text1">
                            <td width="3%" align="center">SL</td>
                            <td width="10%" height="30" style="padding-left:5px;">Name</td>
                            <td width="45%" style="padding-left:5px;">Policy No.</td>
                            <td width="23%" style="padding-left:5px;">Due Date</td>
                            <td width="19%" style="padding-left:5px;">Amount</td>
                          </tr>
                           <?php
                           $hi_pre_tot=0;
                           while($val_hi_premium=$sql_hi_pre_rem_row->fetch_assoc()) {
                            $hi_premium_info=$db->fetchSingle("mediclaim_registration","id='$val_hi_premium[policy_id]'");
                           ?>
                          <tr>
                            <td align="center"><?php echo $pre_count; ?></td>
                            <td style="padding-left:5px;">
                            <a href="add_hi_premiums.php?id=<?php echo $hi_premium_info[id];?>" class="linktext"><?php echo strtoupper($premium_info["name_policy_holder"]); ?></a></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($hi_premium_info["policy_no"]); ?></td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_hi_premium["next_payment_date"])); ?></td>
                            <td style="padding-left:5px;">Rs. <?php echo $val_hi_premium["total_premium_amount"]; ?></td>
                          </tr>
                          <?php 
                          $hi_pre_tot=$hi_pre_tot+$val_hi_premium["total_premium_amount"];
                          $hi_pre_count+=1;
                          } 
                          ?>
                          
                          <tr>
                            <td height="25" colspan="5" align="right" class="error" style="padding-right:155px;">Total = Rs. <?php echo $hi_pre_tot; ?></td>
                            </tr>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>
                      <?php } ?>
                      
                      
                       <!-- Others Reminder-->
                       <?php
                       $other_count=1;
                       $other_rem="SELECT * from other_details where date_to between DATE_SUB(now(), INTERVAL 1 DAY) AND (now()+interval alert_others day) order by date_to";
                       $other_rem_row=$db->mysqli->query($other_rem);
                       $other_num=$other_rem_row->num_rows;
                       if($other_num!=0) { 
                      ?>
                        
                       <tr>
                        <td width="10">&nbsp;</td>
                        <td class="white_heading" height="35" align="center" bgcolor="#FFFFFF"><font color="#003399">OTHERS REMINDER</font></td>
                        </tr>
                     
                      <tr>
                        <td width="10">&nbsp;</td>
                        <td>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                          <tr bgcolor="#999999" class="text1">
                            <td width="3%" align="center">SL</td>
                            <td width="23%" height="30" style="padding-left:5px;">Firm Name</td>
                            <td width="23%" style="padding-left:5px;">Payment Head</td>
                            <td width="21%" style="padding-left:5px;">Paid to</td>
                            <td width="15%" style="padding-left:5px;">Due Date</td>
                            <td width="15%" style="padding-left:5px;">Amount</td>
                          </tr>
                           <?php
                           $other_tot=0;
                           while($val_other=$other_rem_row->fetch_assoc()) {
                            $firm_info=$db->fetchSingle("firms","id='$val_other[firm_id]'");
                            $head_info=$db->fetchSingle("payment_heads","id='$val_other[payment_head_id]'");
                           ?>
                          <tr>
                            <td align="center"><?php echo $other_count; ?></td>
                            <td style="padding-left:5px;">
                            <a href="manage_others.php" class="linktext"><?php echo strtoupper($firm_info[firm_name]); ?></a></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($head_info["heads"]); ?></td>
                            <td style="padding-left:5px;"><?php echo strtoupper($val_other["paid_to"]); ?></td>
                            <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_other["date_to"])); ?></td>
                            <td style="padding-left:5px;">Rs. <?php echo $val_other["amount"]; ?></td>
                          </tr>
                          <?php 
                          $other_tot=$other_tot+$val_other["amount"];
                          $other_count+=1;
                          } 
                          ?>
                          
                          <tr>
                            <td height="25" colspan="6" align="right" class="error" style="padding-right:155px;">Total = Rs. <?php echo $other_tot; ?></td>
                            </tr>
                        </table>
                        </td>
                        <td width="14">&nbsp;</td>
                      </tr>
                      <?php } ?>
                      
                      
                      
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <?php if($num==0 && $ins_num==0 && $tax_num==0 && $fit_num==0 && $per_num==0 && $dl_num==0) { ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="center" class="error"><font color="#FF0000" size="+4">No Results Found</font></td>
                        <td>&nbsp;</td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
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
