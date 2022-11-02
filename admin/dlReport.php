<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <?php
if(isset($_REQUEST['from_date_dl'])){
      $frm_dt = $_REQUEST['from_date_dl'];
    }
    else
    {
      $frm_dt = "";
    }
    if(isset($_REQUEST['to_date_dl'])){
      $to_dt = $_REQUEST['to_date_dl'];
    }
    else
    {
      $to_dt = "";
    }

?>
    <td align="center">
    <form action="" method="post" name="dl" id="dl">
    <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="14%" class="text1">Date from<input type="hidden" name="search" value="due_dl" id="search"></td>
    <td width="31%" class="text1"><input name="from_date_dl" type="text" id="from_date_dl" class="datepick validate[required] textfield121" value="<?php echo $frm_dt; ?>"/></td>
    <td width="12%" class="text1" align="left">Date to</td>
    <td width="28%"><input name="to_date_dl" type="text" id="to_date_dl" class="datepickFuture validate[required] textfield121" value="<?php echo $to_dt; ?>"/></td>
    <td width="15%" align="right"><input type="image" name="imageField" src="images/searchButton.png"></td>
    </tr>
    </table>
    </form>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
   

<?php
if(isset($_REQUEST['search']) && $_REQUEST["search"]=="due_dl")  { 
//DL reminder starts here
$dl_count=1;
echo $sql_dl_rem="SELECT * from  driving_licence where valid_till between '$_REQUEST[from_date_dl]' AND '$_REQUEST[to_date_dl]'";
$sql_dl_rem_row=$db->mysqli->query($sql_dl_rem);
$dl_num=$sql_dl_rem_row->num_rows;
if($dl_num!=0) { 
?>
                
  <tr>
    <td class="white_heading" align="center">&nbsp;</td>
  </tr>
  <tr>
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
                <td style="padding-left:5px;"><?php echo strtoupper($val_dl['first_name']." ".$val_dl['middle_name']." ".$val_dl['last_name']); ?></td>
                <td style="padding-left:5px;"><?php echo $val_dl['contact_no']; ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($val_dl['dl_no']); ?></td>
                <td style="padding-left:5px;"><?php echo date("jS M,Y",strtotime($val_dl['valid_till'])); ?></td>
                <td style="padding-left:5px;"><?php echo strtoupper($val_dl['referred_by']); ?></td>
                <td style="padding-left:5px;"><?php echo $val_dl['referer_mob_no']; ?></td>
                </tr>
                <?php $dl_count+=1;} ?>
                </table>
    </td>
  </tr>
<?php } else { ?>
<tr>
<td height="25" colspan="9" align="center" class="error" style="padding-right:20px;"><strong>No Results Found.</strong></td>
</tr>
<?php } ?>
<?php } ?>
</table>
