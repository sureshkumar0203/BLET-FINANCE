<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
if(isset($_REQUEST['from_date_all'])){
      $frm_dt = $_REQUEST['from_date_all'];
    }
    else
    {
      $frm_dt = "";
    }
    if(isset($_REQUEST['to_date_all'])){
      $to_dt = $_REQUEST['to_date_all'];
    }
    else
    {
      $to_dt = "";
    }

?>
    <td colspan="2" align="center">
    <form action="" method="post" name="all" id="all">
    
    <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="10%" class="text1">Date from<input type="hidden" name="search" value="due_all" id="search"></td>
    <td width="21%" class="text1"><input name="from_date_all" type="text" id="from_date_all" class="datepick validate[required] textfield121" value="<?php echo $frm_dt; ?>"/></td>
    <td width="9%" class="text1" align="left">Date to</td>
    <td width="21%">
    <input name="to_date_all" type="text" id="to_date_all" class="datepickFuture validate[required] textfield121" value="<?php echo $to_dt; ?>"/>
    </td>
    <td width="7%" class="text1">Status</td>
    <td width="17%">
    <select name="all_status" style="border:1px solid #CCC;">
    <option value="tobepaid" <?php if(isset($_REQUEST["all_status"]) && $_REQUEST["all_status"]=="tobepaid") { echo "selected"; } ?>>To be paid</option>
    <option value="paid" <?php if(isset($_REQUEST["all_status"]) && $_REQUEST["all_status"]=="paid") { echo "selected"; } ?>>Paid</option>
    <option value="both" <?php if(isset($_REQUEST["all_status"]) && $_REQUEST["all_status"]=="both") { echo "selected"; } ?>>Both</option>
    </select>
    </td>
    <td width="15%" align="right"><input type="image" name="imageField" src="images/searchButton.png"></td>
    </tr>
    </table>

    </form>
</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" class="text1">
   
    </td>
  </tr>
   
           
  <?php if(isset($_REQUEST["search"]) && $_REQUEST["search"]=="due_all")  { ?>
  
   <tr>
    <td align="left" height="30" class="text1">
     Report from dated 
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date_all"]));?> </font> to
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date_all"])); ?></font>
    </td>
    <td class="white_heading" align="right" style="padding-right:20px;">
    <a href="export_all_report.php?from_date_all=<?php echo $_REQUEST["from_date_all"];?>&to_date_all=<?php echo $_REQUEST["to_date_all"];?>&all_status=<?php echo $_REQUEST["all_status"];?>" class="white_heading" style="padding-right:10px;">Export to excel</a>
    </td>
  </tr>
  
  <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td height="7" colspan="3"></td>
                </tr>
                
                <?php
				 //Finance Reminder starts from here
				 
                $count=1;
				if(isset($_REQUEST["all_status"]) && $_REQUEST["all_status"]=="tobepaid") {
					 $sql="SELECT f.*,i.* FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND next_payment_date between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' AND i.payment_status='Unpaid' group by f.vehicle_id order by i.next_payment_date";
				}
				if(isset($_REQUEST["all_status"]) && $_REQUEST["all_status"]=="paid") {
					 $sql="SELECT f.*,i.* FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND next_payment_date between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' AND i.payment_status='Paid' group by f.vehicle_id order by i.paid_date";
				}
				if(isset($_REQUEST["all_status"]) && $_REQUEST["all_status"]=="both") {
					 $sql="SELECT f.*,i.* FROM finance_details f,installment_details i where f.vehicle_id=i.vehi_id AND next_payment_date between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by paid_date";
				}
				//echo $sql;
                $sql_row=$db->mysqli->query($sql);
                $num=$sql_row->num_rows;
                if($num!=0) { 
                ?>
                <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle" class="white_heading" height="35" bgcolor="#0099FF"><font color="#FFFFFF"><strong>FINANCE</strong></font></td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td width="1279" align="left" valign="top" height="35">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                <tr bgcolor="#999999" class="text1">
                <td width="3%" align="center">SL</td>
                <td width="11%" height="30" style="padding-left:5px;">Vehicle No.</td>
                <td width="10%" height="30" style="padding-left:5px;">Vehicle Type</td>
                <td width="9%" height="30" style="padding-left:5px;">Firm Name</td>
                <td width="13%" height="30" style="padding-left:5px;"><?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Paid") { ?> Paid Date <?php } ?> <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Unpaid") { ?> Due Date <?php } ?> <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="") { ?> Both <?php } ?></td>
                <td width="8%" height="30" style="padding-left:5px;">Finance By</td>
                <td width="11%" height="30" style="padding-left:5px;">Payment Bank</td>
                <td width="11%" height="30" style="padding-left:5px;">Loan A/C No.</td>
                <td width="11%" height="30" style="padding-left:5px;">Payment Status</td>
                <td width="13%" style="padding-left:5px;">Installment Amount</td>
                </tr>
                <?php
                $finance_total=0;
                while($val_inst=$sql_row->fetch_assoc()) { 
                
                $veh_info=$db->fetchSingle("vehicle_registration","id='$val_inst[vehi_id]'");
                //Vehicle Type : Crane , Truck
                $veh_type=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'"); 
				if($val_inst["payment_status"]=="Paid")
				{
					$bgcolor="#009966";
				}
				else
				{
					$bgcolor="#FF0000";
				}
                ?>
                <tr>
                <td height="25" align="center"><?php echo $count; ?></td>
                <td style="padding-left:5px;">
				<a href="add_all_other_info.php?id=<?php echo $veh_info["id"];?>&#tabs-1" class="linktext"><?php echo strtoupper($veh_info["display_no"]); ?></a></td>
                <td style="padding-left:5px;"><?php echo strtoupper($veh_type["vtype"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($val_inst["farm_name"]); ?> </td>
                <td style="padding-left:5px;">
				<?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Paid") { ?> 
				<?php echo date("jS M,Y",strtotime($val_inst["paid_date"])); ?> <?php } ?> 
                
                <?php if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="Unpaid") { ?> 
                <?php echo date("jS M,Y",strtotime($val_inst["next_payment_date"])); ?> <?php } ?> 
                
                <?php 
                if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]=="") {   
                if($val_inst["payment_status"]=="Paid") { 
                ?>
                <?php //echo "<font color='#FF0000'>".date("jS M,Y",strtotime($val_inst["next_payment_date"]))."</font><br>"; ?>
                <?php echo "<font color='#009933'>".date("jS M,Y",strtotime($val_inst["paid_date"]))."</font>"; ?>
                <?php } else { ?>
                <?php echo "<font color='#FF0000'>".date("jS M,Y",strtotime($val_inst["next_payment_date"]))."</font>"; ?>
                <?php } ?>
                <?php } ?>
				</td>
                <td style="padding-left:5px;"><?php echo strtoupper($val_inst["finance_by"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($val_inst["payment_bank"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($val_inst["loan_ac_no"]); ?></td>
                <td style="padding-left:5px;"><font color="<?php echo $bgcolor; ?>"><?php echo strtoupper($val_inst["payment_status"]); ?></font></td>
                <td style="padding-left:5px;">Rs. <?php echo $val_inst["installment_per_month"]; ?></td>
                </tr>
                <?php 
				 $finance_total=$finance_total+$val_inst["installment_per_month"];
				 $count+=1;
				 } 
				 ?>
                
                
                <?php //if($num==0) { ?>
                <tr>
                <td height="25" colspan="10" align="right" class="error" style="padding-right:80px;">Total = Rs. <?php echo $finance_total; ?></td>
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
				if($_REQUEST["all_status"]=="tobepaid") {
				$sql_ins_rem="SELECT * from insurance_details where insurance_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by insurance_to_dt";
				}
				if($_REQUEST["all_status"]=="paid") {
				$sql_ins_rem="SELECT * from insurance_details where date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by date_of_payment";
				}
				if($_REQUEST["all_status"]=="both") {
				$sql_ins_rem="SELECT * from insurance_details where (insurance_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') OR (date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') order by date_of_payment,insurance_to_dt";
				}
                $sql_ins_rem_row=$db->mysqli->query($sql_ins_rem);
                $ins_num=$sql_ins_rem_row->num_rows;
                if($ins_num!=0) { 
                ?>
                
                <tr>
                <td width="7">&nbsp;</td>
                <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF"><strong>INSURANCE</strong></font></td>
                </tr>
                
                <tr>
                <td width="7">&nbsp;</td>
                <td>
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                <tr bgcolor="#999999" class="text1">
                <td width="3%" align="center">SL</td>
                <td width="13%" height="30" style="padding-left:5px;">Vehicle No.</td>
                <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                <td width="20%" height="30" style="padding-left:5px;">Firm Name </td>
                <td width="21%" height="30" style="padding-left:5px;">
                <?php if($_REQUEST["all_status"]=="tobepaid") { ?>Due Date <?php } ?>
                <?php if($_REQUEST["all_status"]=="paid") { ?>Payment Detail<?php } ?>
                <?php if($_REQUEST["all_status"]=="both") { ?>Payment Status<?php } ?>
                </td>
                <td width="20%" style="padding-left:5px;">Insurance Company</td>
                <td width="12%" style="padding-left:5px;">Amount</td>
                </tr>
                <?php
				$ins_tot=0;
                while($val_ins=$sql_ins_rem_row->fetch_assoc()) {
                $veh_info_ins=$db->fetchSingle("vehicle_registration","id='$val_ins[vehicle_id]'");
				$firm = $db->strRecordID("firms", "*", "id='$veh_info_ins[firm_name]'");
                //Vehicle Type : Crane , Truck
                $veh_type_ins=$db->fetchSingle("vehicle_types","id='$veh_info_ins[vehicle_type]'"); 
                ?>
                <tr>
                <td height="25" align="center"><?php echo $ins_count; ?></td>
                <td style="padding-left:5px;"><a href="add_all_other_info.php?id=<?php echo $veh_info_ins["id"];?>&#tabs-2" class="linktext"><?php echo strtoupper($veh_info_ins["display_no"]); ?></a></td>
                <td style="padding-left:5px;"><?php echo strtoupper($veh_type_ins["vtype"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
                <td style="padding-left:5px;">
				<?php if($_REQUEST["all_status"]=="tobepaid") { ?>
				<?php echo date("jS M,Y",strtotime($val_ins["insurance_to_dt"])); ?>
                <?php } ?>
                
                <?php if($_REQUEST["all_status"]=="paid") { ?>
                <?php echo date("jS M,Y",strtotime($val_ins["date_of_payment"])); ?><br />
                <?php echo $val_ins["mode_of_payment"]; ?><br />
                <?php echo $val_ins["cheque_no"]; ?>
                <?php } ?>
				
                 <?php if($_REQUEST["all_status"]=="both") { ?>
                 
				 <?php if($val_ins["date_of_payment"]!="0000-00-00") { ?>
                 <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_ins["date_of_payment"])); ?> <?php } ?></font>
                 <?php if($val_ins["date_of_payment"]=="0000-00-00") { ?>
                 <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_ins["insurance_to_dt"])); ?></b></font>
                 <?php } ?>
                 
                 <?php } ?>
                 
				</td>
                <td style="padding-left:5px;"><?php echo strtoupper($val_ins["insurance_company_name"]); ?></td>
                <td style="padding-left:5px;">Rs. <?php echo $val_ins["total"]; ?></td>
                </tr>
                <?php
				 $ins_count+=1;
				 $ins_tot=$ins_tot+$val_ins["total"];
				}
				?>
               
                <tr>
                <td height="25" colspan="7" align="right" class="error" style="padding-right:80px;">Total = Rs. <?php echo $ins_tot; ?></td>
                </tr>
              
                </table>
                </td>
                <td width="29">&nbsp;</td>
                </tr>
                <?php } ?>
                
                
                <?php
					//Road tax reminder starts here
					$tax_count=1;
					$cond ='';
					
					if($_REQUEST["all_status"]=="tobepaid") 
					{
						$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.tax_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]'  $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
					}
					if($_REQUEST["all_status"]=="paid") 
					{
						$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
					}
					if($_REQUEST["all_status"]=="both")
					{
						$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where (rd.tax_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') OR (rd.date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') AND $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
					}
					
					//echo $sql_tax_rem;
					$sql_tax_rem_row=$db->mysqli->query($sql_tax_rem);
					$tax_num=$sql_tax_rem_row->num_rows;
					if($tax_num!=0) {
                ?>
                <tr>
                <td>&nbsp;</td>
                <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><strong><font color="#FFFFFF">ROAD TAX </font></strong></td>
                <td>&nbsp;</td>
                </tr>                
                <tr>
                <td width="7">&nbsp;</td>
                <td>
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                <tr bgcolor="#999999" class="text1">
                <td width="3%" align="center">SL</td>
                <td width="13%" height="30" style="padding-left:5px;">Vehicle No.</td>
                <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                <td width="20%" height="30" style="padding-left:5px;">Firm Name </td>
                <td width="21%" height="30" style="padding-left:5px;">
				<?php if($_REQUEST["all_status"]=="tobepaid") { ?>Due Date <?php } ?>
                <?php if($_REQUEST["all_status"]=="paid") { ?>Payment Detail<?php } ?>
                 <?php if($_REQUEST["all_status"]=="both") { ?>Payment Status<?php } ?>
                </td>
                <td width="20%" style="padding-left:5px;">RTO Office</td>
                <td width="12%" style="padding-left:5px;">Amount</td>
                </tr>
                <?php
				$road_tax_tot=0;
                while($val_tax=$sql_tax_rem_row->fetch_assoc()) {
                //$veh_info_tax=$dbf->fetchSingle("vehicle_registration","id='$val_tax[vehicle_id]'");
                //Vehicle Type : Crane , Truck
				$firm = $db->strRecordID("firms", "*", "id='$val_tax[firm_name]'");
                $veh_type_tax=$db->fetchSingle("vehicle_types","id='$val_tax[vehicle_type]'");
				$rto = $db->strRecordID("rto_office" , "*", "id='$val_tax[rto_office]'");
                ?>
                <tr>
                <td height="25" align="center"><?php echo $tax_count; ?></td>
                <td style="padding-left:5px;"><a href="add_all_other_info.php?id=<?php echo $veh_info_tax["id"];?>&#tabs-3" class="linktext"><?php echo strtoupper($val_tax["display_no"]); ?></a></td>
                <td style="padding-left:5px;"><?php echo strtoupper($veh_type_tax["vtype"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
                <td style="padding-left:5px;">
				<?php if($_REQUEST["all_status"]=="tobepaid") { ?>
				<?php echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?>
                <?php } ?>
                
                <?php if($_REQUEST["all_status"]=="paid") { ?>
                <?php echo date("jS M,Y",strtotime($val_tax["date_of_payment"])); ?><br />
                <?php echo $val_tax["mode_of_payment"]; ?><br />
                <?php echo $val_tax["cheque_no"]; ?>
                <?php } ?>
				
                 <?php if($_REQUEST["all_status"]=="both") { ?>                 
				 <?php if($val_tax["date_of_payment"]!="0000-00-00") { ?>
                 <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_tax["date_of_payment"])); ?> <?php } ?></font>
                 <?php if($val_tax["date_of_payment"]=="0000-00-00") { ?>
                 <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?></b></font>
                 <?php } ?>
                 <?php } ?>                 
                <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
                <td style="padding-left:5px;">Rs. <?php echo $val_tax["total"]; ?></td>
                </tr>
                <?php 
				$road_tax_tot=$road_tax_tot+$val_tax["total"];
				$tax_count+=1;
				} 
				?>
                <?php //if($tax_num==0) { ?>
                <tr>
                <td height="25" colspan="7" align="right" class="error" style="padding-right:85px;">Total = Rs. <?php echo $road_tax_tot; ?></td>
                </tr>
                <?php //} ?>
                </table>
                </td>
                <td width="29">&nbsp;</td>
                </tr>
                <?php } ?>
                <?php
                //Fitness reminder starts here
                $fit_count=1;
				if($_REQUEST["all_status"]=="tobepaid") {
                $sql_fit_rem="SELECT * from  fitness_details where fitness_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by fitness_to_dt";
				}
				if($_REQUEST["all_status"]=="paid") {
                $sql_fit_rem="SELECT * from  fitness_details where date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by date_of_payment";
				}
				if($_REQUEST["all_status"]=="both") {
                $sql_fit_rem="SELECT * from  fitness_details where (fitness_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') OR (date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') order by date_of_payment,fitness_to_dt";
				}
                $sql_fit_rem_row=$db->mysqli->query($sql_fit_rem);
                $fit_num=$sql_fit_rem_row->num_rows;
                if($fit_num!=0) { 
                ?>
                <tr>
                <td>&nbsp;</td>
                <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF"><strong>FITNESS</strong></font></td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                <td width="7">&nbsp;</td>
                <td>
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                <tr bgcolor="#999999" class="text1">
                <td width="3%" align="center">SL</td>
                <td width="13%" height="30" style="padding-left:5px;">Vehicle No.</td>
                <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                <td width="20%" height="30" style="padding-left:5px;">Firm Name </td>
                <td width="21%" height="30" style="padding-left:5px;">
                <?php if($_REQUEST["all_status"]=="tobepaid") { ?>Due Date <?php } ?>
                <?php if($_REQUEST["all_status"]=="paid") { ?>Payment Detail<?php } ?>
                <?php if($_REQUEST["all_status"]=="both") { ?>Payment Status<?php } ?>
                </td>
                <td width="20%" style="padding-left:5px;">RTO Office</td>
                <td width="12%" style="padding-left:5px;">Amount</td>
                </tr>
                <?php
				$fitness_total=0;
                while($val_fit=$sql_fit_rem_row->fetch_assoc()) {
                $veh_info_fit=$db->fetchSingle("vehicle_registration","id='$val_fit[vehicle_id]'");
				$firm = $db->strRecordID("firms", "*", "id='$veh_info_fit[firm_name]'");
                //Vehicle Type : Crane , Truck
                $veh_type_fit=$db->fetchSingle("vehicle_types","id='$veh_info_fit[vehicle_type]'"); 
				$rto = $db->strRecordID("rto_office" , "*", "id='$val_fit[rto_office]'");
                ?>
                <tr>
                <td height="25" align="center"><?php echo $fit_count; ?></td>
                <td style="padding-left:5px;"><a href="add_all_other_info.php?id=<?php echo $veh_info_fit["id"];?>&#tabs-4" class="linktext"><?php echo strtoupper($veh_info_fit["display_no"]); ?></a></td>
                <td style="padding-left:5px;"><?php echo strtoupper($veh_type_fit["vtype"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
                <td style="padding-left:5px;">
				<?php if($_REQUEST["all_status"]=="tobepaid") { ?>
				<?php echo date("jS M,Y",strtotime($val_fit["fitness_to_dt"])); ?>
                <?php } ?>
                
                <?php if($_REQUEST["all_status"]=="paid") { ?>
                <?php echo date("jS M,Y",strtotime($val_fit["date_of_payment"])); ?><br />
                <?php echo $val_fit["mode_of_payment"]; ?><br />
                <?php echo $val_fit["cheque_no"]; ?>
                <?php } ?>
                
                 <?php if($_REQUEST["all_status"]=="both") { ?>                 
                 <?php if($val_fit["date_of_payment"]!="0000-00-00") { ?>
                 <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_fit["date_of_payment"])); ?> <?php } ?></font>
                 <?php if($val_fit["date_of_payment"]=="0000-00-00") { ?>
                 <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_fit["fitness_to_dt"])); ?></b></font>
                 <?php } ?>                 
                 <?php } ?>                 
				</td>
                <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
                <td style="padding-left:5px;">Rs. <?php echo $val_fit["fitness_amount"]; ?></td>
                </tr>
                <?php 
				$fitness_total=$fitness_total+$val_fit["fitness_amount"];
				$fit_count+=1;} ?>
                <?php //if($fit_num==0) { ?>
                <tr>
                <td height="25" colspan="7" align="right" class="error" style="padding-right:90px;">Total = Rs. <?php echo $fitness_total; ?></td>
                </tr>
                <?php //} ?>
                </table>
                </td>
                <td width="29">&nbsp;</td>
                </tr>
                
                <?php } ?>
                
                
                
                <?php
                //Permit reminder starts here
                $per_count=1;
				if($_REQUEST["all_status"]=="tobepaid") {
                $sql_per_rem="SELECT * from  permit_details where permit_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by permit_to_dt";
				}
				if($_REQUEST["all_status"]=="paid") {
                $sql_per_rem="SELECT * from  permit_details where date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by date_of_payment";
				}
				if($_REQUEST["all_status"]=="both") {
                $sql_per_rem="SELECT * from  permit_details where (permit_to_dt between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') OR (date_of_payment between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]') order by date_of_payment,permit_to_dt";
				}
                $sql_per_rem_row=$db->mysqli->query($sql_per_rem);
                $per_num=$sql_per_rem_row->num_rows;
                if($per_num!=0) { 
                ?>
                <tr>
                <td>&nbsp;</td>
                <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF"><strong>PERMIT</strong></font></td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                <td width="7">&nbsp;</td>
                <td>
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                <tr bgcolor="#999999" class="text1">
                <td width="3%" align="center">SL</td>
                <td width="13%" height="30" style="padding-left:5px;">Vehicle No.</td>
                <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                <td width="20%" height="30" style="padding-left:5px;">Firm Name </td>
                <td width="21%" height="30" style="padding-left:5px;">
                <?php if($_REQUEST["all_status"]=="tobepaid") { ?>Due Date <?php } ?>
                <?php if($_REQUEST["all_status"]=="paid") { ?>Payment Detail<?php } ?>
                <?php if($_REQUEST["all_status"]=="both") { ?>Payment Status<?php } ?>
                </td>
                <td width="20%" style="padding-left:5px;">RTO Office</td>
                <td width="12%" style="padding-left:5px;">Amount</td>
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
                <td height="25" align="center"><?php echo $per_count; ?></td>
                <td style="padding-left:5px;"><a href="add_all_other_info.php?id=<?php echo $veh_info_per["id"];?>&#tabs-5" class="linktext"><?php echo strtoupper($veh_info_per["display_no"]); ?></a></td>
                <td style="padding-left:5px;"><?php echo strtoupper($veh_type_per["vtype"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
                <td style="padding-left:5px;">
				<?php if($_REQUEST["all_status"]=="tobepaid") { ?>
				<?php echo date("jS M,Y",strtotime($val_per["permit_to_dt"])); ?>
                <?php } ?>
                
                <?php if($_REQUEST["all_status"]=="paid") { ?>
                <?php echo date("jS M,Y",strtotime($val_per["date_of_payment"])); ?><br />
                <?php echo $val_per["mode_of_payment"]; ?><br />
                <?php echo $val_per["cheque_no"]; ?>
                <?php } ?>
                
                 <?php if($_REQUEST["all_status"]=="both") { ?>                 
                 <?php if($val_per["date_of_payment"]!="0000-00-00") { ?>
                 <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_per["date_of_payment"])); ?> <?php } ?></font>
                 <?php if($val_per["date_of_payment"]=="0000-00-00") { ?>
                 <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_per["permit_to_dt"])); ?></b></font>
                 <?php } ?>                 
                 <?php } ?>                 
				</td>
                <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
                <td style="padding-left:5px;">Rs. <?php echo $val_per["permit_amount"]; ?></td>
                </tr>
                <?php 
				$permit_total=$permit_total+$val_per["permit_amount"];
				$per_count+=1;
				} 
				?>
                <?php //if($per_num==0) { ?>
                <tr>
                <td height="25" colspan="7" align="right" class="error" style="padding-right:80px;">Total = Rs. <?php echo $permit_total; ?></td>
                </tr>
                <?php //} ?>
                </table>
                </td>
                <td width="29">&nbsp;</td>
                </tr>
                
                <?php } ?>
                
                
                <?php
                //DL reminder starts here
                $dl_count=1;
                $sql_dl_rem="SELECT * from  driving_licence where valid_till between '$_REQUEST[from_date_all]' AND '$_REQUEST[to_date_all]' order by valid_till";
                $sql_dl_rem_row=$db->mysqli->query($sql_dl_rem);
                $dl_num=$sql_dl_rem_row->num_rows;
                if($dl_num!=0) { 
                ?>
                <tr>
                <td>&nbsp;</td>
                <td class="white_heading" height="35" align="center" bgcolor="#0099FF"><font color="#FFFFFF"><strong>DL</strong></font></td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                <td width="7">&nbsp;</td>
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
                <td height="25" align="center"><?php echo $dl_count; ?></td>
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
                <td width="29">&nbsp;</td>
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
                <td align="center" class="error">No Results Found</td>
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
<?php } ?>


</table>
