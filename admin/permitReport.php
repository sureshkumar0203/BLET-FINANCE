<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
if(isset($_REQUEST['from_date_permit'])){
      $frm_dt = $_REQUEST['from_date_permit'];
    }
    else
    {
      $frm_dt = "";
    }
    if(isset($_REQUEST['to_date_permit'])){
      $to_dt = $_REQUEST['to_date_permit'];
    }
    else
    {
      $to_dt = "";
    }

?>
    <td colspan="2" align="center">
    <form action="" method="post" name="permit" id="permit">
    <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="10%" class="text1">Date from<input type="hidden" name="search" value="due_permit" id="search"></td>
    <td width="21%" class="text1"><input name="from_date_permit" type="text" id="from_date_permit" class="datepick validate[required] textfield121" value="<?php echo $frm_dt; ?>" /></td>
    <td width="9%" class="text1" align="left">Date to</td>
    <td width="21%">
    <input name="to_date_permit" type="text" id="to_date_permit" class="datepickFuture validate[required] textfield121" value="<?php echo $to_dt; ?>"/>
    </td>
    <td width="7%" class="text1">Status</td>
    <td width="17%">
    <select name="permit_status" style="border:1px solid #CCC;">
    <option value="tobepaid" <?php if(isset($_REQUEST["permit_status"]) && $_REQUEST["permit_status"]=="tobepaid") { echo "selected"; } ?>>To be paid</option>
    <option value="paid" <?php if(isset($_REQUEST["permit_status"]) && $_REQUEST["permit_status"]=="paid") { echo "selected"; } ?>>Paid</option>
    <option value="both" <?php if(isset($_REQUEST["permit_status"]) && $_REQUEST["permit_status"]=="both") { echo "selected"; } ?>>Both</option>
    </select>
    </td>
    <td width="15%" align="right"><input type="image" name="imageField" src="images/searchButton.png"></td>
    </tr>
    </table>
    </form>
</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
    <?php
	 if(isset($_REQUEST["search"]) && $_REQUEST["search"]=="due_permit")  { 
	//Permit reminder starts here
	$per_count=1;
	if(isset($_REQUEST["permit_status"]) && $_REQUEST["permit_status"]=="tobepaid") 
	{
		$sql_per_rem="SELECT * from  permit_details where permit_to_dt between '".$_REQUEST['from_date_permit']."' AND '".$_REQUEST['to_date_permit']."' order by permit_to_dt";
	}
	if(isset($_REQUEST["permit_status"]) && $_REQUEST["permit_status"]=="paid") 
	{
		$sql_per_rem="SELECT * from  permit_details where date_of_payment between '".$_REQUEST['from_date_permit']."' AND '".$_REQUEST['to_date_permit']."' order by date_of_payment";
	}
	if(isset($_REQUEST["permit_status"]) && $_REQUEST["permit_status"]=="both") 
	{
		$sql_per_rem="SELECT * from  permit_details where (permit_to_dt between '".$_REQUEST['from_date_permit']."' AND '".$_REQUEST['to_date_permit']."') OR (date_of_payment between '".$_REQUEST['from_date_permit']."' AND '".$_REQUEST['to_date_permit']."') order by date_of_payment,permit_to_dt";
	}
	$sql_per_rem_row=$db->mysqli->query($sql_per_rem);
	$per_num=$sql_per_rem_row->num_rows;
	if($per_num!=0) { 
	?>
  <tr>
    <td class="text1" align="left" height="30"> 
    Permit report from dated 
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date_permit"]));?> </font> to
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date_permit"])); ?></font>
    </td>
    <td class="white_heading" align="right">
    <a href="export_permit_report.php?from_date_permit=<?php echo $_REQUEST["from_date_permit"];?>&to_date_permit=<?php echo $_REQUEST["to_date_permit"];?>&permit_status=<?php echo $_REQUEST["permit_status"];?>" class="white_heading" style="padding-right:10px;">Export to excel</a>
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                <tr bgcolor="#999999" class="text1">
                <td width="3%" align="center">SL</td>
                <td width="13%" height="42" style="padding-left:5px;">Vehicle No.</td>
                <td width="11%" style="padding-left:5px;">Vehicle Type</td>
                <td width="20%" height="42" style="padding-left:5px;">Firm Name </td>
                <td width="21%" height="42" style="padding-left:5px;">
                <?php if($_REQUEST["permit_status"]=="tobepaid") { ?>Due Date  <?php } ?>
                <?php if($_REQUEST["permit_status"]=="paid") { ?>Payment Detail<?php } ?>
                <?php if($_REQUEST["permit_status"]=="both") { ?>Payment Status<?php } ?>
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
				$rto = $db->strRecordID("rto_office" , "*", "id='$veh_info_per[rto_office]'");
				//print_r($rto);exit;
                ?>
                <tr>
                <td height="25" align="center"><?php echo $per_count; ?></td>
                <td style="padding-left:5px;"><a href="add_all_other_info.php?id=<?php echo $veh_info_per["id"];?>&#tabs-5" class="linktext"><?php echo strtoupper($veh_info_per["display_no"]); ?></a></td>
                <td style="padding-left:5px;"><?php echo strtoupper($veh_type_per["vtype"]); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
                <td style="padding-left:5px;">
				<?php if($_REQUEST["permit_status"]=="tobepaid") { ?>
				<?php echo date("jS M,Y",strtotime($val_per["permit_to_dt"])); ?>
                <?php } ?>
                
                <?php if($_REQUEST["permit_status"]=="paid") { ?>
                <?php echo date("jS M,Y",strtotime($val_per["date_of_payment"])); ?><br />
                <?php echo $val_per["mode_of_payment"]; ?><br />
                <?php echo $val_per["cheque_no"]; ?>
                <?php } ?>
				
                 <?php if($_REQUEST["permit_status"]=="both") { ?>
                 
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
                <td height="25" colspan="7" align="right" class="error" style="padding-right:95px;">Total = Rs. <?php echo $permit_total; ?></td>
                </tr>
                <?php //} ?>
                </table>
    </td>
  </tr>
<?php } else { ?>
<tr>
<td height="25" colspan="10" align="center" class="error" style="padding-right:20px;"><strong>No Results Found.</strong></td>
</tr>
<?php } ?>
<?php } ?>
</table>
