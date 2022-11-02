<?php
ob_start();
//session_start();
//include_once '../includes/class.Main.php';
include_once '../includes/class.dbFunctions.php';
$db = new Dbfunctions();

//Object initialization
//$dbf = new User();
?>



<table width="1200" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="40" align="left" valign="top" class="text1">
  Other Report 
</td>
</tr>

<tr>
<td>
<table height="61" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#ACACAC"  class="tablesorter" id="sort_table" width="100%">
<thead>
  <tr>
    <th width="200" height="27" align="left" valign="middle" class="fetch_headers">Firm Name</th>
    <th width="200" align="left" valign="middle" class="fetch_headers">Payment Head</th>
    <th width="200" align="left" valign="middle" class="fetch_headers">Paid to</th>
    <th width="200" align="left" valign="middle" class="fetch_headers">Amount</th>
    <th width="400" align="left" valign="middle" class="fetch_headers">
      <?php if(isset($_REQUEST["payment_status"])=="tobepaid") { ?>Due Date <?php } ?>
      <?php if(isset($_REQUEST["payment_status"])=="Paid") { ?>Paid Date <?php } ?>
      <?php if(isset($_REQUEST["payment_status"])=="both") { ?>Both <?php } ?>
      <?php if(isset($_REQUEST["payment_status"])=="") { ?>Due Date / Paid Date<?php } ?>
    </th>
    </tr>
</thead>
<tbody>
<?php
  $sch="";
  if(isset($_REQUEST["firm_id"])!="")
  {
      $sch="firm_id='$_REQUEST[firm_id]' AND ";
  }
  
  if(isset($_REQUEST["payment_head_id"])!="")
  {
      $sch=$sch."payment_head_id='$_REQUEST[payment_head_id]' AND ";
  }

  if(isset($_REQUEST["payment_status"])=="tobepaid")
  {
      $sch=$sch."date_to between '$_REQUEST[date_from]' AND '$_REQUEST[date_to]' AND ";
  }
  if(isset($_REQUEST["payment_status"])=="Paid")
  {
      $sch=$sch."payment_date between '$_REQUEST[date_from]' AND '$_REQUEST[date_to]' AND ";
  }
  if(isset($_REQUEST["payment_status"])=="both")
  {
      $sch=$sch."(date_to between '$_REQUEST[date_from]' AND '$_REQUEST[date_to]') OR (payment_date between '$_REQUEST[date_from]' AND '$_REQUEST[date_to]') AND ";
  }
  $sch=substr($sch,0,-4);
  
  if($sch!='')
  {		
       $src="select * from other_details where ".$sch."";
  }
  
  elseif($sch=='')
  {		
     $src="select * from other_details";
  }
  //echo  $src;
  $src_row=$db->mysqli->query($src);
  $num=$src_row->num_rows;
  ?>
  <?php
  $total="";
   while($other_info=$src_row->fetch_assoc())
   {

        $firm_det=$db->fetchSingle("firms","id='$other_info[firm_id]'"); 
        $payment_det=$db->fetchSingle("payment_heads","id='$other_info[payment_head_id]'"); 
        $bank_det=$db->fetchSingle("bank_details","id='$other_info[bank_id]'"); 
  ?>
  <tr bgcolor="<?=$color;?>"  onmouseover="this.style.backgroundColor='#E6E6E6'" onMouseOut="this.style.backgroundColor=''">
    <td height="30" align="left" class="fetch_contents" style="padding-left:3px;">
     <?php  echo strtoupper($firm_det["firm_name"]);  ?>
    </td>
    <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo $payment_det["heads"];  ?></td>
    <td align="left" class="fetch_contents" style="padding-left:3px;"><?php  echo strtoupper($other_info["paid_to"]);  ?></td>
    <td align="left" class="fetch_contents" style="padding-left:3px;">Rs. <?php  echo number_format($other_info["amount"],2);  ?></td>
    <td align="left" class="fetch_contents" style="padding-left:3px;">
      <?php if($_REQUEST["payment_status"]=="tobepaid") { ?>
      <?php  echo date("jS M,Y",strtotime($other_info[date_to]));  ?>
      <?php } ?>
      
      <?php if($_REQUEST["payment_status"]=="Paid") { ?>
      <?php  echo date("jS M,Y",strtotime($other_info[payment_date]));  ?>
      <?php } ?>
      
      <?php if($_REQUEST["payment_status"]=="both") { ?>
      <font color="#FF0000"><?php  echo date("jS M,Y",strtotime($other_info[date_to]));  ?> </font>- 
      <font color="#009900"><?php  echo date("jS M,Y",strtotime($other_info[payment_date]));  ?> </font>
      <?php } ?>
      
      <?php if($_REQUEST["payment_status"]=="") { ?>
      <font color="#FF0000"><?php  echo date("jS M,Y",strtotime($other_info[date_to]));  ?> </font>- 
      <font color="#009900"><?php  echo date("jS M,Y",strtotime($other_info[payment_date]));  ?> </font>
      <?php $total=$total+$other_info["amount"]; } ?>
      
      
    </td>
    </tr>
  <?php } ?>
  
   <tr>
    <td colspan="5" align="center" class="text1"><p>Total = Rs. 
    <?php
       echo number_format($total,2,'.',''); ?></p></td>
  </tr>
  
  
  <?php if($num==0) { ?>
  <tr>
    <td colspan="5" align="center" class="noRecords2"><font color="#FF0000">No Records Found !!!!</font></td>
  </tr>
  <?php } ?>
</tbody>
</table>
</td>
</tr>
</table>