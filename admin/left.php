<?php
include_once '../includes/class.Main.php';
?>
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<!--<link rel="stylesheet" href="css/styles.css">		
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
    <?php /*?><div id="wrapper">
    <ul class="menu">
		<li class="item1"><a href="#">Friends <span>340</span></a>
			<ul>
				<li class="subitem1"><a href="#">Cute Kittens <span>14</span></a></li>
				<li class="subitem2"><a href="#">Strange "Stuff" <span>6</span></a></li>
				<li class="subitem3"><a href="#">Automatic Fails <span>2</span></a></li>
			</ul>
		</li>
		<li class="item2"><a href="#">Videos <span>147</span></a>
			<ul>
				<li class="subitem1"><a href="#">Cute Kittens <span>14</span></a></li>
				<li class="subitem2"><a href="#">Strange "Stuff" <span>6</span></a></li>
				<li class="subitem3"><a href="#">Automatic Fails <span>2</span></a></li>
			</ul>
		</li>
		<li class="item3"><a href="#">Galleries <span>340</span></a>
			<ul>
				<li class="subitem1"><a href="#">Cute Kittens <span>14</span></a></li>
				<li class="subitem2"><a href="#">Strange "Stuff" <span>6</span></a></li>
				<li class="subitem3"><a href="#">Automatic Fails <span>2</span></a></li>
			</ul>
		</li>
		<li class="item4"><a href="#">Podcasts <span>222</span></a>
			<ul>
				<li class="subitem1"><a href="#">Cute Kittens <span>14</span></a></li>
				<li class="subitem2"><a href="#">Strange "Stuff" <span>6</span></a></li>
				<li class="subitem3"><a href="#">Automatic Fails <span>2</span></a></li>
			</ul>
		</li>
		<li class="item5"><a href="#">Robots <span>16</span></a>
			<ul>
				<li class="subitem1"><a href="#">Cute Kittens <span>14</span></a></li>
				<li class="subitem2"><a href="#">Strange "Stuff" <span>6</span></a></li>
				<li class="subitem3"><a href="#">Automatic Fails <span>2</span></a></li>
			</ul>
		</li>
	</ul>
    </div>
	<script type="text/javascript">
		$(function() {
		
			var menu_ul = $('.menu > li > ul'),
				   menu_a  = $('.menu > li > a');
			
			menu_ul.hide();
		
			menu_a.click(function(e) {
				e.preventDefault();
				if(!$(this).hasClass('active')) {
					menu_a.removeClass('active');
					menu_ul.filter(':visible').slideUp('normal');
					$(this).addClass('active').next().stop(true,true).slideDown('normal');
				} else {
					$(this).removeClass('active');
					$(this).next().stop(true,true).slideUp('normal');
				}
			});
		
		});
	</script><?php */?>
    <table width="200" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;box-shadow: 2px 2px 5px 2px #cCC;">
      <tr>
        <td width="15" align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="30" align="left" valign="middle" class="menuheading">&nbsp;Menus </td>
      </tr>
      <tr>
        <td height="1" colspan="2" align="left" valign="middle" bgcolor="#a8afa6"></td>
        </tr>
      <tr>
        <td align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
		    <td width="14%" height="25" align="left" valign="middle"><img src="images/vehicle.png" width="16" height="16" /></td>
		    <td width="86%" height="25"><a href="manage_vehicles.php" class="submenu">Manage Vehicle</a></td>
		    </tr>
            <tr>
		    <td height="25" align="left" valign="middle"><img src="images/document.png" width="16" height="16" /></td>
		    <td height="25"><a href="insu_step_manage.php" class="submenu">Insurance Claim Procedure</a></td>
		    </tr>
             <tr>
		    <td height="25" align="left" valign="middle"><img src="images/license.png" width="16" height="16" /></td>
		    <td height="25"><a href="manage_driving_licence.php" class="submenu">Manage Driving Licence</a></td>
		    </tr>
            
             <tr>
		    <td height="25" align="left" valign="middle"><img src="images/company.png" width="16" height="16" /></td>
		    <td height="25"><a href="manage_firm_name.php" class="submenu">Manage Firm Name</a></td>
		    </tr>
            
           <tr>
		    <td height="25" align="left" valign="middle"><img src="images/insu.png" width="16" height="16" /></td>
		    <td height="25"><a href="manage_lic.php" class="submenu">Manage LIC</a></td>
		    </tr>
            <tr>
		    <td height="25" align="left" valign="middle"><img src="images/health.png" width="16" height="16" /></td>
		    <td height="25"><a href="manage_mediclaim.php" class="submenu">Manage Health Insurance</a></td>
		    </tr>
          <!--<tr>
		    <td height="25" align="left" valign="middle"><img src="images/road.png" width="16" height="16" /></td>
		    <td height="25"><a href="road_tax.php" class="submenu">Manage Road Tax</a></td>
		  </tr>-->
          <tr>
		    <td height="25" align="left" valign="middle"><img src="images/road.png" width="16" height="16" /></td>
		    <td height="25"><a href="head_manage.php" class="submenu">Head Creation</a></td>
		  </tr>
		  <tr>
		    <td height="25" align="left" valign="middle"><img src="images/other.png" width="16" height="16" /></td>
		    <td height="25"><a href="manage_others.php" class="submenu">Manage Others</a></td>
		  </tr>
        </table></td>
      </tr>
       <tr>
        <td height="1" colspan="2" align="left" valign="middle" bgcolor="#a8afa6"></td>
        </tr>
       <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading"><a href="report.php" class="menuheading" style="text-decoration:none;">&nbsp;Vehicle Report</a></td>
      </tr>       
      <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading"><a href="report_statistic.php" class="menuheading" style="text-decoration:none;">&nbsp;Statistical Report</a></td>
      </tr>
      <!--<tr>
        <td align="left" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="30" align="left" valign="middle" class="menuheading"><a href="report_road_tax.php" class="menuheading" style="text-decoration:none;">Road Tax Report</a></td>
      </tr>-->
      <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading"><a href="all_insurance_report.php" class="menuheading" style="text-decoration:none;">&nbsp;Insurance Report</a></td>
      </tr>
       <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading"><a href="report_finance.php" class="menuheading" style="text-decoration:none;">&nbsp;Finance Report</a></td>
      </tr>
      <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading"><a href="report_lic.php" class="menuheading" style="text-decoration:none;">&nbsp;LIC Status Report</a></td>
      </tr>
      <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading"><a href="report_lic.php" class="menuheading" style="text-decoration:none;">&nbsp;LIC Dues Report</a></td>
      </tr>
      <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading"><a href="report_other.php" class="menuheading" style="text-decoration:none;">&nbsp;Other Report</a></td>
      </tr>
       <tr align="right">
        <td height="1" colspan="2" valign="middle" bgcolor="#a8afa6"></td>
        </tr>
       <tr>
        <td align="right" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
        <td height="22" align="left" valign="middle" class="menuheading">&nbsp;My Accounts</td>
      </tr>
       <tr>
        <td height="1" colspan="2" align="left" valign="middle" bgcolor="#a8afa6"></td>
        </tr>
      <tr>
        <td align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25" align="left" valign="middle"><img src="images/big-arrow.jpg" alt="arrow" width="9" height="8" /></td>
            <td height="22"><a href="change_password.php" class="submenu">Change Password </a></td>
          </tr>
        </table></td>
      </tr>      
      <tr>
        <td align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>