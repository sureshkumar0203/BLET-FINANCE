<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
   if(isset($_REQUEST['from_date_road_tax'])){
      $frm_dt = $_REQUEST['from_date_road_tax'];
    }
    else
    {
      $frm_dt = "";
    }
    if(isset($_REQUEST['to_date_road_tax'])){
      $to_dt = $_REQUEST['to_date_road_tax'];
    }
    else
    {
      $to_dt = "";
    }
    ?>
    <td colspan="2" align="center">
    <form action="" name="road_tax" id="road_tax">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="8%" class="text1">Date from<input type="hidden" name="search" value="due_roadtax" id="search"></td>
    <td width="18%" class="text1"><input name="from_date_road_tax" type="text" id="from_date_road_tax" value="<?php echo $frm_dt; ?>" class="datepick validate[required] textfield121" value="<?php echo isset($_REQUEST['from_date_road_tax']);?>"/></td>
    <td width="6%" class="text1" align="left">Date to</td>
    <td width="18%">
    <input name="to_date_road_tax" type="text" id="to_date_road_tax" class="datepick validate[required] textfield121" value="<?php echo $to_dt; ?>"/>
    </td>
    <td width="6%" class="text1">Status</td>
    <td width="12%">
    <select name="rt_status" style="border:1px solid #CCC;">
    <option value="tobepaid" <?php if(isset($_REQUEST["rt_status"]) && $_REQUEST["rt_status"]=="tobepaid") { echo "selected"; } ?>>To be paid</option>
    <option value="paid" <?php if(isset($_REQUEST["rt_status"]) && $_REQUEST["rt_status"]=="paid") { echo "selected"; } ?>>Paid</option>
     <option value="both" <?php if(isset($_REQUEST["rt_status"]) && $_REQUEST["rt_status"]=="both") { echo "selected"; } ?>>Both</option>
    </select>
    </td>
    <td width="8%" class="text1">Company </td>
    <td width="11%"><select name="firms" style="border:1px solid #CCC;" id="firms">
    <option value="">--Select--</option>
    <?php foreach($db->fetch('firms') as $res_firm) { ?>
    <option value="<?php echo $res_firm["id"];?>" <?php if(isset($_REQUEST["firms"]) && $_REQUEST["firms"]==$res_firm["id"]) { echo "selected"; } ?>><?php echo $res_firm["firm_name"];?></option>
    <?php } ?>
    </select>
    </td>
    <td width="13%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td width="55%" align="left" valign="middle"><input type="image" name="imageField" src="images/searchButton.png" /></td>
          <td width="45%" align="left" valign="middle" class="noRecords2"><input type="checkbox" name="all" id="all" <?php if(isset($_REQUEST["all"]) && $_REQUEST["all"]){?> checked="checked" <?php } ?> />All</td>
        </tr>
    </table></td>
    </tr>
    </table>
    </form>
</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <?php
    if(isset($_REQUEST["search"]) && $_REQUEST["search"]=="due_roadtax")  { 
	
	//Road tax reminder starts here
	$tax_count=1;
	if($_REQUEST["firms"]!="")
	{
		$cond="AND vr.firm_name='$_REQUEST[firms]'";
	}
	else
	{
		$cond="";
	}
	if($_REQUEST["rt_status"]=="tobepaid") 
	{
		$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]'  $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
	}
	if($_REQUEST["rt_status"]=="paid") 
	{
		$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
		
		//$sql_tax_rem="SELECT * from roadtax_details where date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' group by vehicle_id order by date_of_payment";
	}
	if($_REQUEST["rt_status"]=="both")
	{
		
		$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]'  $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id";
		
		$sql_tax_rem=$sql_tax_rem." UNION ALL SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id";
		
		//Suresh code
		/*$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where (rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') OR (rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";*/
		
		//$sql_tax_rem="SELECT * from roadtax_details where (tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') OR (date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') group by vehicle_id order by date_of_payment,tax_to_dt";
	}
	
	//echo $sql_tax_rem;
	$sql_tax_rem_row=$db->mysqli->query($sql_tax_rem);
	$tax_num=$sql_tax_rem_row->num_rows;
	if($tax_num!=0) { 
	?>
  <tr>
    <td class="text1" align="left" height="30">
      Roadtax report from dated 
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["from_date_road_tax"]));?> </font> to
    <font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST["to_date_road_tax"])); ?></font>
    </td>
    <td class="white_heading" align="right"><?php if(isset($_REQUEST["all"]) && $_REQUEST["all"] != ""){?>
     <a href="export_roadtax_report.php?from_date_road_tax=<?php echo $_REQUEST["from_date_road_tax"];?>&to_date_road_tax=<?php echo $_REQUEST['to_date_road_tax'];?>&rt_status=<?php echo $_REQUEST['rt_status'];?>&firms=<?php echo $_REQUEST['firms'];?>" class="white_heading" style="padding-right:10px;">Export to excel</a><?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top">
    
    <?php if(isset($_REQUEST["all"]) && $_REQUEST["all"] != ''){?>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
        <tr bgcolor="#999999" class="text1">
            <td width="4%" align="center">SL</td>
            <td width="11%" height="30" style="padding-left:5px;">Vehicle No.</td>
            <td width="16%" style="padding-left:5px;">Vehicle Type</td>
            <td width="6%" align="center" valign="middle" style="padding-left:5px;">Axle</td>
            <td width="16%" height="30" style="padding-left:5px;">Firm Name </td>
            <td width="17%" height="30" style="padding-left:5px;">
            <?php if($_REQUEST["rt_status"]=="tobepaid") { ?>Due Date <?php } ?>
            <?php if($_REQUEST["rt_status"]=="paid") { ?>Payment Detail<?php } ?>
             <?php if($_REQUEST["rt_status"]=="both") { ?>Payment Status<?php } ?>            </td>
            <td width="16%" style="padding-left:5px;">RTO Office</td>
            <td width="14%" style="padding-left:5px;">Amount</td>
        </tr>
        <?php
        $road_tax_tot=0;
        while($val_tax=$sql_tax_rem_row->fetch_assoc()) {
        //$veh_info_tax=$db->fetchSingle("vehicle_registration","id='$val_tax[vehicle_id]'");
        //Vehicle Type : Crane , Truck
        $firm = $db->strRecordID("firms", "*", "id='$val_tax[firm_name]'");
        $veh_type_tax=$db->fetchSingle("vehicle_types","id='$val_tax[vehicle_type]'"); 
        $rto = $db->strRecordID("rto_office" , "*", "id='$val_tax[rto_office]'");
        ?>
        <tr>
            <td height="25" align="center"><?php echo $tax_count; ?></td>
            <td style="padding-left:5px;"><a href="add_all_other_info.php?id=<?php echo $veh_info_tax['id'];?>&#tabs-3" class="linktext"><?php echo strtoupper($val_tax["display_no"]); ?></a></td>
            <td style="padding-left:5px;"><?php echo strtoupper($veh_type_tax["vtype"]); ?></td>
            <td align="center" valign="middle" style="padding-left:5px;"><?php  echo $val_tax["no_of_axle"];  ?></td>
            <td style="padding-left:5px;"><?php echo strtoupper($firm["firm_name"]); ?> </td>
            <td style="padding-left:5px;">
            <?php if($_REQUEST["rt_status"]=="tobepaid") { ?>
            <?php echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?>
            <?php } ?>
            
            <?php if($_REQUEST["rt_status"]=="paid") { ?>
            <?php echo date("jS M,Y",strtotime($val_tax["date_of_payment"])); ?><br />
            <?php echo $val_tax["mode_of_payment"]; ?><br />
            <?php echo $val_tax["cheque_no"]; ?>
            <?php } ?>
            
             <?php if($_REQUEST["rt_status"]=="both") { ?>
             
             <?php if($val_tax["date_of_payment"]!="0000-00-00") { ?>
             <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_tax["date_of_payment"])); ?> <?php } ?></font>
             <?php if($val_tax["date_of_payment"]=="0000-00-00") { ?>
             <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?></b></font>
             <?php } ?>
    
             <?php } ?>
            <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
            <td align="right" valign="middle" style="padding-left:5px;">Rs <?php echo number_format($val_tax["total"],2);?>&nbsp;</td>
        </tr>
        <?php 
        $road_tax_tot=$road_tax_tot+$val_tax["total"];
        $tax_count+=1;
        } 
        ?>
        <?php //if($tax_num==0) { ?>
        <tr>
        <td height="25" colspan="8" align="right" valign="middle" class="error" >Total = Rs. <?php echo number_format($road_tax_tot,2); ?>&nbsp;</td>
        </tr>
                <?php //} ?>
      </table>
    <?php }else{ ?>
    <?php
	foreach($db->fetchOrder('rto_office',"","id") as $firms) {
	?>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
        <tr bgcolor="#999999" class="text1">
            <td width="4%" align="center">SL</td>
            <td width="11%" height="30" style="padding-left:5px;">Vehicle No.</td>
            <td width="16%" style="padding-left:5px;">Vehicle Type</td>
            <td width="6%" align="center" valign="middle" style="padding-left:5px;">Axle</td>
            <td width="16%" height="30" style="padding-left:5px;">Firm Name </td>
            <td width="17%" height="30" style="padding-left:5px;">
            <?php if($_REQUEST["rt_status"]=="tobepaid") { ?>Due Date <?php } ?>
            <?php if($_REQUEST["rt_status"]=="paid") { ?>Payment Detail<?php } ?>
             <?php if($_REQUEST["rt_status"]=="both") { ?>Payment Status<?php } ?>            </td>
            <td width="16%" style="padding-left:5px;">RTO Office</td>
            <td width="14%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="31%" align="center" valign="middle">
                  <a href="report_road_export.php?rto_id=<?php echo $firms["id"];?>&from_date_road_tax=<?php echo $_REQUEST["from_date_road_tax"];?>&to_date_road_tax=<?php echo $_REQUEST["to_date_road_tax"];?>&rt_status=<?php echo $_REQUEST["rt_status"];?>&firms=<?php echo $_REQUEST["firms"];?>"><img src="images/xls.png" width="16" height="16" border="0" /></a>                  </td>
                  <td width="69%" align="right" valign="middle">Amount&nbsp;</td>
                </tr>
            </table></td>
        </tr>
		<?php
        $road_tax_tot=0;
		
		if($_REQUEST["search"]=="due_roadtax"){ 
	
			//Road tax reminder starts here
			$tax_count=1;
			
			if($_REQUEST["rt_status"]=="tobepaid"){
				$sql_tax_rem="SELECT * from roadtax_details where tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' group by vehicle_id";
				/*$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' And vr.firm_name='$firms[id]' And vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";*/
			}
			if($_REQUEST["rt_status"]=="paid"){
				$sql_tax_rem="SELECT * from roadtax_details where date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' group by vehicle_id";
				/*$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' And vr.firm_name='$firms[id]' And vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";*/
			}
			if($_REQUEST["rt_status"]=="both"){
				$sql_tax_rem="SELECT * from roadtax_details where (tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') OR (date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') group by vehicle_id";
				/*$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where (rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') OR (rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') And vr.firm_name='$firms[id]' And vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";*/
			}
		
		//echo $sql_tax_rem;
		
		$sql_tax_rem_row=$db->mysqli->query($sql_tax_rem);
        while($val_tax=$sql_tax_rem_row->fetch_assoc()) {
        	//echo "<pre>";print_r($val_tax);exit;
		
		$vehicle = $db->strRecordID("vehicle_registration" , "*", "id='$val_tax[vehicle_id]' And rto_office='$firms[id]'");
		if($vehicle["vehicle_no"] != ""){
		
			$veh_type_tax=$db->fetchSingle("vehicle_types","id='$vehicle[vehicle_type]'"); 
			$rto = $db->strRecordID("firms" , "*", "id='$vehicle[firm_name]'");
			
        ?>
        <tr>
            <td height="25" align="center"><?php echo $tax_count; ?></td>
            <td style="padding-left:5px;"><?php echo strtoupper($vehicle["display_no"]); ?></td>
            <td style="padding-left:5px;"><?php echo strtoupper($veh_type_tax["vtype"]); ?></td>
            <td align="center" valign="middle" style="padding-left:5px;">
			<?php  //echo $val_tax["no_of_axle"]; ?>
            </td>
            <td style="padding-left:5px;"><?php echo strtoupper($rto["firm_name"]); ?> </td>
            <td style="padding-left:5px;">
            <?php if($_REQUEST["rt_status"]=="tobepaid") { ?>
            <?php echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?>
            <?php } ?>
            
            <?php if($_REQUEST["rt_status"]=="paid") { ?>
            <?php echo date("jS M,Y",strtotime($val_tax["date_of_payment"])); ?><br />
            <?php echo $val_tax["mode_of_payment"]; ?><br />
            <?php echo $val_tax["cheque_no"]; ?>
            <?php } ?>
            
             <?php if($_REQUEST["rt_status"]=="both") { ?>
             
             <?php if($val_tax["date_of_payment"]!="0000-00-00") { ?>
             <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_tax["date_of_payment"])); ?> <?php } ?></font>
             <?php if($val_tax["date_of_payment"]=="0000-00-00") { ?>
             <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_tax["tax_to_dt"])); ?></b></font>
             <?php } ?>

             <?php } ?>
            <td style="padding-left:5px;"><?php echo strtoupper($firms["rto_name"]); ?></td>
            <td align="right" valign="middle" style="padding-left:5px;">Rs <?php echo number_format($val_tax["total"],2);?>&nbsp;</td>
        </tr>
            <?php
            $road_tax_tot=$road_tax_tot+$val_tax["total"];
            $tax_count+=1;
            }}}
            ?>
            <tr>
            <td height="25" colspan="8" align="right" valign="middle" class="error" ><?php if($road_tax_tot > 0){?>
            Total = Rs. <?php echo number_format($road_tax_tot,2);?>&nbsp;<?php } ?></td>
        </tr>
      </table>
    <?php } ?>  
    <?php } ?>
    </td>
  </tr>
<?php } else { ?>
<tr>
<td height="25" colspan="10" align="center" class="error" style="padding-right:20px;"><strong>No Results Found.</strong></td>
</tr>
<?php } ?>
<?php } ?>
</table>
