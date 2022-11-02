<?php
ob_start();
//session_start();

//include_once('../includes/ExportToExcel.class.php');
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//Object initialization
//$dbf = new User();

?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
    <tr bgcolor="#999999" class="text1">
        <td width="3%" align="center">SL</td>
        <td width="13%" height="30" style="padding-left:5px;">Vehicle No.</td>
        <td width="11%" style="padding-left:5px;">Vehicle Type</td>
        <td width="20%" height="30" style="padding-left:5px;">Firm Name </td>
        <td width="21%" height="30" style="padding-left:5px;">
        <?php if($_REQUEST["rt_status"]=="tobepaid") { ?>Due Date <?php } ?>
        <?php if($_REQUEST["rt_status"]=="paid") { ?>Payment Detail<?php } ?>
         <?php if($_REQUEST["rt_status"]=="both") { ?>Payment Status<?php } ?>
        </td>
      <td width="20%" style="padding-left:5px;">RTO Office</td>
      <td width="12%" align="right">Amount&nbsp;</td>
    </tr>
    <?php
    $road_tax_tot=0;
    
	//Road tax reminder starts here
	$tax_count=1;
	
	if(isset($_REQUEST["rt_status"])=="tobepaid"){
		$sql_tax_rem="SELECT * from roadtax_details where tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' group by vehicle_id";
		/*$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' And vr.firm_name='$firms[id]' And vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";*/
	}
	if(isset($_REQUEST["rt_status"])=="paid"){
		$sql_tax_rem="SELECT * from roadtax_details where date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' group by vehicle_id";
		/*$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' And vr.firm_name='$firms[id]' And vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";*/
	}
	if(isset($_REQUEST["rt_status"])=="both"){
		$sql_tax_rem="SELECT * from roadtax_details where (tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') OR (date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') group by vehicle_id";
	}
    
    //echo $sql_tax_rem;
    $rto_name = $db->getDataFromTable("rto_office", "rto_name", "id='$_REQUEST[rto_id]'");
    $sql_tax_rem_row=$db->mysqli->query($sql_tax_rem);
    while($val_tax=$sql_tax_rem_row->fetch_assoc()) {
    
    $vehicle = $db->strRecordID("vehicle_registration" , "*", "id='$val_tax[vehicle_id]' And rto_office='$_REQUEST[rto_id]'");
    if($vehicle["vehicle_no"] != ""){
    
        $veh_type_tax=$db->fetchSingle("vehicle_types","id='$vehicle[vehicle_type]'"); 
        $firm = $db->strRecordID("firms" , "*", "id='$vehicle[firm_name]'");        
    ?>
    <tr>
        <td height="25" align="center"><?php echo $tax_count; ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($vehicle["display_no"]); ?></td>
        <td style="padding-left:5px;"><?php echo strtoupper($veh_type_tax["vtype"]); ?></td>
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
         
        <td style="padding-left:5px;"><?php echo strtoupper($rto_name); ?></td>
        <td align="right" valign="middle" style="padding-left:5px;">Rs <?php echo number_format($val_tax["total"],2);?>&nbsp;</td>
        </tr>
        <?php
        $road_tax_tot=$road_tax_tot+$val_tax["total"];
        $tax_count+=1;
        }}
        ?>
        <tr>
        <td height="25" colspan="7" align="right" valign="middle" class="error" ><?php if($road_tax_tot > 0){?>
        Total = Rs. <?php echo number_format($road_tax_tot,2);?>&nbsp;<?php } ?></td>
    </tr>
</table>
