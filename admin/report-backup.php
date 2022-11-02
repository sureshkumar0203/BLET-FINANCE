<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
$pageTitle='Admin Panel';
include 'application_top.php';
//Object initialization
$dbf = new User();

if(isset($_SESSION['admin_id'])=="")
{
	header("location:index.php");
	exit;
}

?>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	$(function() {

		$( "#tabs" ).tabs({
			cookie: {
				// store cookie for a week, without, it would be a session cookie
				expires: 7
			}
		});
		
		var $tabs = $("#tabs").tabs();
		$('#mylink').click(function() { // bind click event to link
    $tabs.tabs('select', 2); // switch to third tab
    return false;
	
	
});


	$('#mylink2').click(function() { // bind click event to link
    $tabs.tabs('select', 4); // switch to third tab
    return false;
	
	
	
});

	});



</script>	
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="left" valign="top"><img src="images/leftbox-bg.jpg" alt="leftboxbg" width="10" height="38" /></td>
                      <td class="midboxbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="50%" align="left" valign="middle"><h2>Report</h2></td>
                          <td width="50%" align="right" valign="middle"><h2><a href="report.php">Home</a></h2></td>
                        </tr>
                      </table></td>
                      <td width="10" align="right" valign="top"><img src="images/rightbox-bg.jpg" alt="rightboxbg" width="10" height="38" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#e2e2e2" height="320">
                <div class="demo pageContainer">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-8">Finance</a></li>
                        <li><a href="#tabs-9">Insurance</a></li>
                        <li><a href="#tabs-10">Road Tax</a></li>
                        <li><a href="#tabs-11">Fitness</a></li>
                        <li><a href="#tabs-12">Permit</a></li>
                        <li><a href="#tabs-13">DL</a></li>
                        <li><a href="#tabs-14">All</a></li>
                    </ul>
                    <div id="tabs-8">
                    <?php include("financeReport.php"); ?>
                    </div>
                    
                     <div id="tabs-9">
                    <?php include("insuranceReport.php"); ?>
                    </div>
                    
                     <div id="tabs-10">
                    <?php include("roadTaxReport.php"); ?>
                    </div>
                    
                    <div id="tabs-11">
                    <?php include("fitnessReport.php"); ?>
                    </div>
                    
                     <div id="tabs-12">
                    <?php include("permitReport.php"); ?>
                    </div>
                    
                    <div id="tabs-13">
                    <?php include("dlReport.php"); ?>
                    </div>
                    
                    <div id="tabs-14">
                    <?php include("allReport.php"); ?>
                    </div>
                    
                </div>
                </div>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="5" align="left" valign="top"><img src="images/bottom-left-box-bg.jpg" alt="bot_left_bg" width="5" height="5" /></td>
                      <td height="5" class="botmidboxbg"></td>
                      <td width="5"><img src="images/bot-right-box-bg.jpg" alt="bot_right" width="5" height="5" /></td>
                    </tr>
                </table></td>
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
