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
?>
<style>
.myButton {
  -moz-box-shadow:inset 0px 1px 3px 0px #91b8b3;
  -webkit-box-shadow:inset 0px 1px 3px 0px #91b8b3;
  box-shadow:inset 0px 1px 3px 0px #91b8b3;
  background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #768d87), color-stop(1, #6c7c7c));
  background:-moz-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:-webkit-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:-o-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:-ms-linear-gradient(top, #768d87 5%, #6c7c7c 100%);
  background:linear-gradient(to bottom, #768d87 5%, #6c7c7c 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#768d87', endColorstr='#6c7c7c',GradientType=0);
  background-color:#768d87;
  -moz-border-radius:5px;
  -webkit-border-radius:5px;
  border-radius:12px;
  border:1px solid #566963;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-family:Arial;
  font-size:10px;
  font-weight:bold;
  padding:11px 23px;
  text-decoration:none;
  text-shadow:0px -1px 0px #2b665e;
}
.myButton:hover {
  background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #6c7c7c), color-stop(1, #768d87));
  background:-moz-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:-webkit-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:-o-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:-ms-linear-gradient(top, #6c7c7c 5%, #768d87 100%);
  background:linear-gradient(to bottom, #6c7c7c 5%, #768d87 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#6c7c7c', endColorstr='#768d87',GradientType=0);
  background-color:#6c7c7c;
}
.myButton:active {
  position:relative;
  top:1px;
}

</style>
<?php

                  if(isset($_REQUEST['sub'])){
                                 $firms = $_REQUEST['firms'];
                                  $xl = $_REQUEST['xl'];

                                 
                                  if(!empty($xl)){
                                       $implode_xl = implode(",",$xl);
                                       $count_xl = count($xl);
                                  }else
                                  {
                                    $count_xl=0;
                                  }

                                // echo $count_xl = count($xl);

                                  $type = $_REQUEST['type'];
                                  if(!empty($type)){
                                      $implode_type = implode(",",$type);
                                      $count_type = count($type);
                                  }else{
                                    $count_type = 0;
                                  }

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
            <td width="220" align="left" valign="top" ><?php include 'left.php';?></td>
            <td width="1088" align="left" valign="top" style="padding-left:3px;">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="33%">&nbsp;</td>
                  <td width="56%">&nbsp;</td>
                  <td width="11%" align="center" valign="middle">
                  <h2><a href="admin_home.php" class="linkButton">Cancel</a></h2></td>
                </tr>
                <tr>
                  <td colspan="3" align="center" valign="middle"><table width="80%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="18%" height="25" align="center" valign="middle" class="startext">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-shadow: 5px 3px 55px #f00; border-collapse:collapse;">
                        <tr>
                          <td align="center" valign="middle">Report Option(s)</td>
                        </tr>
                      </table>
                      </td>
                      <td width="73%">&nbsp;</td>
                      <td width="9%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td align="left" valign="middle">
                      
                      <form name="frm" id="frm" method="post" action="">
                      <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#CCCCCC">
                        <tr>
                          <td width="6%" align="center" valign="middle" class="success">1.</td>
                          <td width="56%" height="25" align="left" valign="middle" class="text2">&nbsp;No of Vehicle Company wise</td>
                          <td width="38%" align="center" valign="middle">
                          <select name="firms" id="firms" style="border:1px solid #CCC; height:20px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('firms',"","firm_name","","") as $val) { ?>
                            <option value="<?php echo $val['id'];?>" <?php if(isset($_REQUEST["firms"]) == $val["id"]){?> selected <?php }?>><?php echo $val["firm_name"]; ?></option>
                             <?php } ?>
                          </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle" class="success">2.</td>
                          <td height="25" align="left" valign="middle" class="text2">&nbsp;No of Vehicle Axle wise</td>
                          <td align="center" valign="middle">


                          <select name="xl[]" id="xl[]" style="border:1px solid #CCC; width:150px;"  multiple="">
                            <?php for($i=1;$i<=4;$i++) {
            								
          								?>
                            <option value="<?php echo $i;?>" <?php if($is_select != ""){?> selected <?php }?>><?php echo $i;?>&nbsp;xl</option>
                             <?php } ?>
                          </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" valign="top" class="success">3.</td>
                          <td height="25" align="left" valign="top" class="text2">&nbsp;No of Vehicle Tyep wise (<span class="noRecords2">i.e Truck,Car</span>)</td>
                          <td align="center" valign="middle"> 
                          <select name="type[]" id="type[]" style="border:1px solid #CCC; width:150px;" multiple="">
                            <?php foreach($db->fetch('vehicle_types',"","vtype","","") as $val) {
            								?>
                            <option value="<?php echo $val['id']; ?>" <?php if($is_select != ""){?> selected <?php }?>><?php echo $val["vtype"]; ?></option>
                             <?php } ?>
                          </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">&nbsp;</td>
                          <td height="22" align="right" valign="middle" class="text2"><!--<input name="image" type="image" src="images/searchButton.png" /> -->
                          <input type="submit" name="sub" id="sub" value="Search" class="myButton">
                          </td>
                          <td>&nbsp;</td>
                        </tr>
                        </table>
                      </form>  
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td height="30">&nbsp;</td>
                      <td align="center" valign="middle"><a href="report_statistic_csv.php?firms=<?php echo $firms;?>&implode_xl=<?php echo $implode_xl;?>&count_xl=<?php echo $count_xl;?>&implode_type=<?php echo $implode_type;?>&count_type=<?php echo $count_type;?>"><img src="images/xls.png" width="16" height="16"></a></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td colspan="3" align="center" valign="middle">
                  
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
                              if($firms > 0){
            
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
                       <?php } } ?>
                            

                      </tbody>
                    </table>                  
                  </td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
            <td width="15" align="left" valign="top">&nbsp;</td>
            </tr>
        </table></td>
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
