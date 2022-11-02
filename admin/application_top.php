<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMIN PANEL</title>

<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="js/jquery-1.3.2.min.js"></script>

<!--for tab -->
<link rel="stylesheet" href="tabcss/style.css">
<link rel="stylesheet" href="tabcss/jquery.ui.all.css">
<link rel="stylesheet" href="tabcss/demos.css">

<script src="tabjs/jquery-1.6.2.js"></script>
<script src="tabjs/jquery.cookie.js"></script>
<script src="tabjs/jquery.ui.core.js"></script>
<script src="tabjs/jquery.ui.widget.js"></script>
<script src="tabjs/jquery.ui.tabs.js"></script>

<!--for tab -->    
  
<!--phone,price Validation-->
<script type="text/javascript" src="js/filter_textbox.js"></script>
<script type="text/javascript" src="js/myfun.js"></script>


<!--MODAL POPUP WINDOW-->
<script type="text/javascript" src="js/thickbox.js"></script>
<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />


<!--JQUERY VALIDATION-->
<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>

<script>	
$(document).ready(function() {
	$("#frm").validationEngine()
});

</script>	

<!--JQUERY VALIDATION ENDS-->

<!--wysiwyg editor-->
<script type="text/javascript" src="../editor/wysiwyg.js"></script>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script src="../ckeditor/sample.js" type="text/javascript"></script>
<link href="../ckeditor/sample.css" rel="stylesheet" type="text/css" />


<!--TABLE SORTER-->
<link rel="stylesheet" href="table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->


<!--UI JQUERY DATE PICKER-->

<link rel="stylesheet" href="../datepicker/jquery.ui.all.css">
	<script src="../datepicker/jquery.ui.core.js"></script>
	<script src="../datepicker/jquery.ui.widget.js"></script>
	<script src="../datepicker/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="../datepicker/demos.css">
	<script>
	$(function() {
		$( ".datepick" ).datepicker({
			changeMonth: true,
			changeYear: true,
			//dateFormat: 'dd/mm/yy',
			dateFormat: 'yy-mm-dd',
			yearRange:"1942:+60"
		});
	});
	
	$(function() {
		$( ".datepickFuture" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			//numberOfMonths: 2,
			minDate: new Date(),
			//maxDate: new Date(2011, 10, 25, 17, 30),
		});
	});
	
	$(function() {
		$( ".datepickWeek" ).datepicker({
		    showWeek: true,
			firstDay: 1,
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-M-yy'
		});
	});
	</script>
	<script>
$(function() {
	$( "#start_date" ).datepicker({
		defaultDate: "",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#end_date" ).datepicker({
		defaultDate: "",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<?php 
//date_default_timezone_set ("Europe/London"); 
//date_default_timezone_set ("Asia/Calcutta"); 
?>
</head>