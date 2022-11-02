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

$res_reg=$db->fetchSingle("vehicle_registration","id='$_REQUEST[id]'"); 
$veh_no=$res_reg["vehicle_no"];
$vehicle_no1=substr($veh_no,0,1);
$vehicle_no2=substr($veh_no,1,1);
$vehicle_no3=substr($veh_no,2,1);
$vehicle_no4=substr($veh_no,3,1);
$vehicle_no5=substr($veh_no,4,1);
$vehicle_no6=substr($veh_no,5,1);
$vehicle_no7=substr($veh_no,6,1);
$vehicle_no8=substr($veh_no,7,1);
$vehicle_no9=substr($veh_no,8,1);
$vehicle_no10=substr($veh_no,9,1);

if(isset($_POST["submit"])<>'')
{
		$vehicle_no=strtoupper($_POST[vehicle_no1].$_POST[vehicle_no2].$_POST[vehicle_no3].$_POST[vehicle_no4].$_POST[vehicle_no5].$_POST[vehicle_no6].$_POST[vehicle_no7].$_POST[vehicle_no8].$_POST[vehicle_no9].$_POST[vehicle_no10]);
		$vlen=strlen($vehicle_no);
	
	 if($vlen==10)
	 {
		 $display_no=$_POST[vehicle_no1].$_POST[vehicle_no2]."-".$_POST[vehicle_no3].$_POST[vehicle_no4].$_POST[vehicle_no5].$_POST[vehicle_no6]."-".$_POST[vehicle_no7].$_POST[vehicle_no8].$_POST[vehicle_no9].$_POST[vehicle_no10];
	 }
	 
	 if($vlen==9)
	 {
		 $display_no=$_POST[vehicle_no1].$_POST[vehicle_no2]."-".$_POST[vehicle_no3].$_POST[vehicle_no4].$_POST[vehicle_no5]."-".$_POST[vehicle_no6].$_POST[vehicle_no7].$_POST[vehicle_no8].$_POST[vehicle_no9];
	 }
	 
	 if($vlen==8)
	 {
		 $display_no=$_POST[vehicle_no1].$_POST[vehicle_no2]."-".$_POST[vehicle_no3].$_POST[vehicle_no4]."-".$_POST[vehicle_no5].$_POST[vehicle_no6].$_POST[vehicle_no7].$_POST[vehicle_no8];
	 }
	 
	 if($vlen==7)
	 {
		 $display_no=$_POST[vehicle_no1].$_POST[vehicle_no2].$_POST[vehicle_no3]."-".$_POST[vehicle_no4].$_POST[vehicle_no5].$_POST[vehicle_no6].$_POST[vehicle_no7];
	 }
	 
	 if($vlen==6)
	 {
		 $display_no=$_POST[vehicle_no1].$_POST[vehicle_no2].$_POST[vehicle_no3]."-".$_POST[vehicle_no4].$_POST[vehicle_no5].$_POST[vehicle_no6];
	 }
	 
	$num=$db->countRows('vehicle_registration',"vehicle_no='$vehicle_no' AND id!='$_REQUEST[id]'");
	if($num>0)
	{
		header("Location:edit_vehicle_registration.php?id=$_REQUEST[id]&msg=exist");
	}
	else
	{
		//Upadte vehicle_registration table
		$string="vehicle_type='$_POST[vehicle_type]',rto_office='$_POST[rto_office]',vehicle_no='$vehicle_no',display_no='$display_no',purchase_mode='$_POST[purchase_mode]',manufacture_name='$_POST[manufacture_name]',year_of_manufacturing='$_POST[year_of_manufacturing]',vehicle_model='$_POST[vehicle_model]',no_of_axle='$_POST[no_of_axle]',carrying_capacity='$_POST[carrying_capacity]',cost_of_vehicle='$_POST[cost_of_vehicle]',rate_of_depreciation='$_REQUEST[rate_of_depreciation]',firm_name='$_REQUEST[firm_name]'";
		
		$db->updateTable("vehicle_registration",$string,"id='$_REQUEST[id]'");
	    header("Location:edit_vehicle_registration.php?id=$_REQUEST[id]&msg=updated");
	}
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCC; background-color:#FFF;">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Edit Vehicle Registration</h2></td>
                          <td width="50%" align="right" valign="middle"></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" height="320">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="righttableborder2">
                  <tr>
                    <td>
					<form action="" method="post" id="frm" enctype="multipart/form-data">
                      <table width="90%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:10px;">
                   
                        <tr>
                          <td height="30" colspan="4" align="left" valign="middle">
                           <?php if(isset($_REQUEST["msg"]) && $_REQUEST["msg"]=='updated'){ ?>
                          <span class="success">Record has been updated successfully</span>. 
                          <?php } ?>
                          <?php if(isset($_REQUEST["msg"]) && $_REQUEST["msg"]=='exist'){ ?>
                           <span class="error">This vehicle type already exist. </span>
                          <?php } ?>
                          </td>
                        </tr>
						
                        <tr>
                          <td align="left" valign="middle" class="text1">Vehicle No. :</td>
                          <td height="30" align="left" valign="bottom" class="text1">
						  <table width="240" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="20">
         <input name="vehicle_no1" type="text" class="validate[required]" id="vehicle_no1" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no1; ?>"/>
                            </td>
                            <td width="20">
         <input name="vehicle_no2" type="text" class="validate[required]" id="vehicle_no2" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no2; ?>"/>
                            </td>
                            <td width="20">&nbsp;</td>
                            <td width="20">
                            <input name="vehicle_no3" type="text" class="validate[required]" id="vehicle_no3" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no3; ?>"/>
                            </td>
                            <td width="20">
                            <input name="vehicle_no4" type="text" class="validate[required]" id="vehicle_no4" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no4; ?>"/>
                            </td>
                            <td width="20">
                            <input name="vehicle_no5" type="text" class="validate[required]" id="vehicle_no5" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no5; ?>"/>
                            </td>
                            <td width="20">
                            <input name="vehicle_no6" type="text" class="validate[required]" id="vehicle_no6" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no6; ?>"/>
                            </td>
                            <td width="20">&nbsp;</td>
                            <td width="20">
                            <input name="vehicle_no7" type="text" id="vehicle_no7" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no7; ?>"/>
                            </td>
                            <td width="20">
                            <input name="vehicle_no8" type="text" class="" id="vehicle_no8" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no8; ?>"/>
                            </td>
                            <td width="20"><input name="vehicle_no9" type="text" class="" id="vehicle_no9" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no9; ?>"/></td>
                            <td width="20">
                            <input name="vehicle_no10" type="text" class="" id="vehicle_no10" style="text-transform:uppercase; width:20px; border:1px solid #999;" autocomplete="off" maxlength="1" value="<?php echo $vehicle_no10; ?>"/>
                            </td>
                          </tr>
                        </table></td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                         </tr>
                         
                        <tr>
                          <td width="22%" align="left" valign="middle" class="text1"> Type of Vehicle: </td>
                          <td width="75%" height="30" align="left" valign="bottom" class="text1">
						  <select name="vehicle_type" class="validate[required]" id="vehicle_type" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('vehicle_types',"","vtype","","") as $val) { ?>
                            <option value="<?php echo $val["id"]; ?>" <?php if($res_reg["vehicle_type"]==$val["id"]) { echo "selected"; }?>><?php echo $val["vtype"]; ?></option>
                             <?php } ?>
                          </select>
                          </td>
                          <td width="3%" height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                        </tr>
                       <tr>
                         <td align="left" valign="middle" class="text1">RTO Office</td>
                         <td height="30" align="left" valign="bottom" class="text1">
                            <select name="rto_office" class="validate[required]" id="rto_office" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('rto_office',"","") as $rto) { ?>
                            <option value="<?php echo $rto["id"]; ?>" <?php if($rto["id"] == $res_reg["rto_office"]){?> selected="" <?php } ?>><?php echo $rto["rto_name"]; ?></option>
                            <?php } ?>
                            </select>
                         </td>
                         <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                       </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Manufacturer Name : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="manufacture_name" type="text" class="validate[required] textfield121" id="manufacture_name" style="text-transform:uppercase;" autocomplete="off" value="<?php echo $res_reg["manufacture_name"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Year of Manufacturing :</td>
                             <td height="30" align="left" valign="bottom" class="text1"><input name="year_of_manufacturing" type="text" class="datepick validate[required] textfield121" id="year_of_manufacturing" readonly="readonly" value="<?php echo $res_reg["year_of_manufacturing"]; ?>"/></td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Model :</td>
                             <td height="30" align="left" valign="bottom" class="text1"><input name="vehicle_model" type="text" class="validate[required] textfield121" id="vehicle_model" style="text-transform:uppercase;" autocomplete="off" value="<?php echo $res_reg["vehicle_model"]; ?>"/></td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">No. of Axle : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <select name="no_of_axle" class="validate[required]" id="no_of_axle" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php for($i=1;$i<=4;$i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($res_reg["no_of_axle"]==$i) { echo "selected"; }?>><?php echo $i; ?></option>
                             <?php } ?>
                          </select>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Carrying Capacity : </td>
                             <td height="30" align="left" valign="bottom" class="text1"><input name="carrying_capacity" type="text" class="validate[required] textfield121" id="carrying_capacity" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_reg["carrying_capacity"]; ?>"/></td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Cost of vehicle : </td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="cost_of_vehicle" type="text" class="validate[required] textfield121" id="cost_of_vehicle" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_reg["cost_of_vehicle"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                             <td align="left" valign="middle" class="text1">Rate of depreciation  :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <input name="rate_of_depreciation" type="text" class="validate[required] textfield121" id="rate_of_depreciation" onBlur="extractNumber(this,2,false)" onKeyUp="extractNumber(this,2,false)" onKeyPress="return blockNonNumbers(this, event, true, false);" value="<?php echo $res_reg["rate_of_depreciation"]; ?>"/>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           <tr>
                          <td align="left" valign="middle" class="text1">Mode of Purchase : </td>
                          <td height="30" align="left" valign="bottom" class="text1">
						  <select name="purchase_mode" class="validate[required]" id="purchase_mode" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <option value="Cash" <?php if($res_reg["purchase_mode"]=="Cash") { echo "selected"; }?>>Cash</option>
                            <option value="Loan" <?php if($res_reg["purchase_mode"]=="Loan") { echo "selected"; }?>>Loan</option>
                          </select></td>
                          <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                         </tr>
                        
                        <tr>
                             <td align="left" valign="middle" class="text1">Firm Name  :</td>
                             <td height="30" align="left" valign="bottom" class="text1">
                             <select name="firm_name" class="validate[required]" id="firm_name" style="border:1px solid #CCC; height:25px; width:150px;">
                            <option value="">--Select--</option>
                            <?php foreach($db->fetch('firms',"","firm_name","","") as $val) { ?>
                            <option value="<?php echo $val["id"]; ?>" <?php if($res_reg["firm_name"]==$val["id"]) { echo "selected"; }?>><?php echo $val["firm_name"]; ?></option>
                             <?php } ?>
                          </select>
                             </td>
                             <td height="25" colspan="2" align="left" valign="middle">&nbsp;</td>
                           </tr>
                           
                           
                        <tr>
                          <td height="10" colspan="4" align="left" class="headingtext"></td>
                          </tr>
                    
                        
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td height="40" colspan="6" align="left"><input name="submit" type="submit" class="button" id="submit" value="Submit">&nbsp;               					    <input name="submit2" type="button" class="button" id="submit2" value="Cancel" onClick="javascript:window.location='manage_vehicles.php'"></td>
                          </tr>
                        <tr>
                          <td align="left">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                          <td colspan="5" align="left">&nbsp;</td>
                        </tr>
                      </table>
                    </form></td>
                  </tr>
                </table>
				</td>
              </tr>
              <tr>
                <td align="left" valign="top"></td>
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
