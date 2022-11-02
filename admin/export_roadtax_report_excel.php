<?php
ob_start();
session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();

//Object initialization
//$dbf = new User();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
//Road tax reminder starts here
	$tax_count=1;
	if($_REQUEST[firms]!="")
	{
		$cond="AND vr.firm_name='$_REQUEST[firms]'";
	}
	else
	{
		$cond="";
	}
	if($_REQUEST[rt_status]=="tobepaid") 
	{
		$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]'  $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
	}
	if($_REQUEST[rt_status]=="paid") 
	{
		$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
		
		//$sql_tax_rem="SELECT * from roadtax_details where date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]' group by vehicle_id order by date_of_payment";
	}
	if($_REQUEST[rt_status]=="both")
	{
		$sql_tax_rem="SELECT rd.*,vr.* from roadtax_details rd,vehicle_registration vr where (rd.tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') OR (rd.date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') AND $cond AND vr.id=rd.vehicle_id group by rd.vehicle_id order by vr.rto_office";
		
		//$sql_tax_rem="SELECT * from roadtax_details where (tax_to_dt between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') OR (date_of_payment between '$_REQUEST[from_date_road_tax]' AND '$_REQUEST[to_date_road_tax]') group by vehicle_id order by date_of_payment,tax_to_dt";
	}

//echo $sql_tax_rem;
$sql_tax_rem_row=$db->mysqli->query($sql_tax_rem);
$tax_num=$sql_tax_rem_row->num_rows;
if($tax_num!=0) { 
?>
<tr>
<td class="text1" align="left" height="40" valign="top">
Roadtax report from dated 
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST['from_date_road_tax']));?> </font> to
<font color="#FF0000"><?php echo date("jS M,Y",strtotime($_REQUEST['to_date_road_tax'])); ?></font>
</td>
<td class="white_heading" align="right">&nbsp;</td>
</tr>
<tr>
<td colspan="2">
  <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #999; border-collapse:collapse;">
                <tr bgcolor="#999999" class="text1">
                <td width="5%" align="center">SL</td>
                <td width="11%" height="30" style="padding-left:5px;">Vehicle No.</td>
                <td width="15%" style="padding-left:5px;">Vehicle Type</td>
                <td width="6%" align="center" valign="middle" style="padding-left:5px;">Axle</td>
                <td width="16%" height="30" style="padding-left:5px;">Firm Name </td>
                <td width="17%" height="30" style="padding-left:5px;">
				<?php if($_REQUEST['rt_status']=="tobepaid") { ?>Due Date <?php } ?>
                <?php if($_REQUEST['rt_status']=="paid") { ?>Payment Detail<?php } ?>
                 <?php if($_REQUEST['rt_status']=="both") { ?>Payment Status<?php } ?>                </td>
                <td width="16%" style="padding-left:5px;">RTO Office</td>
                <td width="14%" style="padding-left:5px;">Amount</td>
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
                <td style="padding-left:5px;"><?php echo strtoupper($val_tax['display_no']); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($veh_type_tax['vtype']); ?></td>
                <td align="center" valign="middle"><?php  echo $val_tax['no_of_axle'];  ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($firm['firm_name']); ?> </td>
                <td style="padding-left:5px;">
				<?php if($_REQUEST['rt_status']=="tobepaid") { ?>
				<?php echo date("jS M,Y",strtotime($val_tax['tax_to_dt'])); ?>
                <?php } ?>
                
                <?php if($_REQUEST['rt_status']=="paid") { ?>
                <?php echo date("jS M,Y",strtotime($val_tax['date_of_payment'])); ?><br />
                <?php echo $val_tax['mode_of_payment']; ?><br />
                <?php echo $val_tax['cheque_no']; ?>
                <?php } ?>
				
                 <?php if($_REQUEST['rt_status']=="both") { ?>
                 
				 <?php if($val_tax['date_of_payment']!="0000-00-00") { ?>
                 <font color="#006600">Paid Date - <?php echo date("jS M,Y",strtotime($val_tax['date_of_payment'])); ?> <?php } ?></font>
                 <?php if($val_tax['date_of_payment']=="0000-00-00") { ?>
                 <font color="#FF0000"><b>Due dt - &nbsp;&nbsp;&nbsp;<?php  echo date("jS M,Y",strtotime($val_tax['tax_to_dt'])); ?></b></font>
                 <?php } ?>

                 <?php } ?>
                <td style="padding-left:5px;"><?php echo strtoupper($rto["rto_name"]); ?></td>
                <td style="padding-left:5px;"><?php echo $val_tax['total']; ?></td>
                </tr>
                <?php 
				$road_tax_tot=$road_tax_tot+$val_tax['total'];
				$tax_count+=1;
				} 
				?>
                <?php //if($tax_num==0) { ?>
                <tr>
                <td height="25" colspan="8" align="right" class="error">Total = Rs. <?php echo $road_tax_tot; ?></td>
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

</table>