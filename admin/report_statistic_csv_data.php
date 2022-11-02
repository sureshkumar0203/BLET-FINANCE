<?php
ob_start();
//session_start();

//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();
//Object initialization
//$db = new User();
?>
<style>
.fetch_headers {font-family:Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color:#000000;border-bottom:solid 1px #ACACAC;white-space:nowrap;padding-left:5px;}
table.tablesorter {font-family:arial;background-color: #CDCDCD;margin-top:10px;font-size: 12px;width:100%;border-collapse:collapse;text-align: left;}
/*change this coolor for header*/
table.tablesorter thead tr th, table.tablesorter tfoot tr th {background-color:#ccc;font-size: 11px;padding: 2px;font-weight:bold;color:#000;}
table.tablesorter thead tr .header {background-image: url(bg.gif);background-repeat: no-repeat;background-position: center right;cursor: pointer;}
table.tablesorter tbody td {color: #000000;	padding: 4px;	background-color: #FFF;	vertical-align: middle;	font-size:11px;}
</style>
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#ACACAC" class="tablesorter" width="95%">
      <thead>
        <tr>
          <th width="4%" align="center" valign="middle" class="fetch_headers">Sl.</th>
          <th width="15%" height="27" align="left" valign="middle" class="fetch_headers">Vehicle No.</th>
          <th width="13%" align="left" valign="middle" class="fetch_headers">Vehicle Type</th>
          <th width="6%" align="center" valign="middle" class="fetch_headers">No.  <br>of Axle</th>
          <th width="10%" align="center" valign="middle" class="fetch_headers">Carrying <br>Capacity</th>
          <th width="20%" align="left" valign="middle" class="fetch_headers">Model</th>
          <th width="12%" align="center" valign="middle" class="fetch_headers">Manufacturing<br>
Year</th>
          <th width="12%" align="right" valign="middle" class="fetch_headers">Cost of vehicle</th>
          <th width="8%" align="center" valign="middle" class="fetch_headers">Purchase<br>
            Mode </th>
          </tr>
      </thead>
      <tbody>
					                 <?php
                              			$firms = $_REQUEST['firms'];
                              			$implode_xl = $_REQUEST['implode_xl'];
                              			$count_xl = $_REQUEST['count_xl'];
                              			$implode_type = $_REQUEST['implode_type'];
                              			$count_type = $_REQUEST['count_type'];
                                // echo $count_type = count($type);
                                 
                                  
                                 // FIND_IN_SET('C', 'A,B,C,D')
                                  if($firms != '' && $count_xl == 0 && $count_type == 0){
                                     $sch = "select * from vehicle_registration where firm_name='$firms' ";
                                  }
                                  else if($firms != '' && $count_xl > 0 && $count_type == 0){
                                     $sch = "select * from vehicle_registration where firm_name='$firms' and no_of_axle in($implode_xl) ";
                                  }
                                  else if($firms != '' && $count_xl == 0 && $count_type > 0){
                                     $sch = "select * from vehicle_registration where firm_name='$firms' and vehicle_type in($implode_type) ";
                                  }
                                  else if($firms != '' && $count_xl > 0 && $count_type > 0){
                                     $sch = "select * from vehicle_registration where firm_name='$firms' and no_of_axle in($implode_xl) and vehicle_type in($implode_type) ";
                                  }

                                  $src_row=$db->mysqli->query($sch);
                                  $num=$src_row->num_rows;
            if($num > 0){
            $i = 1;
            while($veh_info=$src_row->fetch_assoc()){
              
              $firm = $db->strRecordID("firms", "*", "id='$veh_info[firm_name]'");
              $veh_typ=$db->fetchSingle("vehicle_types","id='$veh_info[vehicle_type]'");
              $no_of_installment_remaining=$db->countRows('installment_details',"vehi_id=$veh_info[id] AND payment_status='Unpaid'");
                  ?>
                        <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
                          <td align="center" class="fetch_contents"><?php echo $i;?></td>
                          <td align="left" class="fetch_contents"><?php echo strtoupper($veh_info["display_no"]);?></td>
                          <td align="left" class="fetch_contents"><?php echo strtoupper($veh_typ["vtype"]); ?></td>
                          <td align="center" valign="middle" class="fetch_contents"><?php  echo $veh_info["no_of_axle"];  ?></td>
                          <td align="center" valign="middle" class="fetch_contents"><?php  echo $veh_info["carrying_capacity"];  ?></td>
                          <td align="left" class="fetch_contents"><?php  echo strtoupper($veh_info["vehicle_model"]);  ?></td>
                          <td align="left" class="fetch_contents"><?php  echo date("jS M,Y",strtotime($veh_info["year_of_manufacturing"]));  ?></td>
                          <td align="right" class="fetch_contents" ><?php echo number_format($veh_info["cost_of_vehicle"],2);?></td>
                          <td align="center" valign="middle" class="fetch_contents"><?php echo strtoupper($veh_info["purchase_mode"]); ?></td>
                          </tr>
                        <?php $i++; } ?>                        
                        <?php if($num==0) { ?>
                        <tr>
                          <td colspan="13" align="center" class="noRecords2"><font color="#FF0000">No Records Found !!!!</font></td>
                        </tr>
                       <?php }  }?>
                            

                      </tbody>
    </table>