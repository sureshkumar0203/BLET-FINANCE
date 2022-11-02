<style type="text/css">
<!--
.style3 {
	font-family: Algerian;
	color: #E8E8E8;
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background: url(images/top_bg.jpg) repeat-x;">
  <tr> 
    <td width="50%" height="50" align="left" valign="middle" style="padding-left:23px;">
    <a href="admin_home.php" class="style3" style="text-decoraon:none; font-size:18px;">BLE FINANCE REMINDER</a></td>
    <td width="50%" align="right" valign="top" style="padding-right:5px;">
	<?php
	if ($db->get_session())
	{
	$client_name=$db->getDataFromTable('admin', 'admin_name',  "id='$_SESSION[admin_id]'");
	?>
	<table width="250" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="8" colspan="3" align="center" valign="middle" class="logouttext"></td>
        </tr>
      <tr>
        <td width="156" align="center" valign="middle" class="logouttext">Welcome : <?php echo $client_name; ?> </td>
        <td width="24" align="center" valign="middle"><a href="logout.php"><img src="images/logout-icon.png" alt="logout_icon" width="15" height="15" border="0"/></a></td>
        <td width="70" align="left" valign="middle"><a href="logout.php" class="logouttext">Logout</a></td>
      </tr>
      <tr>
        <td height="10" colspan="3"></td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
	<?php
	}
	?>	</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="middle" class="greenborder" >&nbsp;</td>
  </tr>
</table>
