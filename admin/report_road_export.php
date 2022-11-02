<?php
ob_start();
session_start();

include_once('../includes/ExportToExcel.class.php');
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
$exp = new ExportToExcel();

$rto_name = $dbf->getDataFromTable("rto_office", "rto_name", "id='$_REQUEST[rto_id]'");
$rto_name = "tax_payment_at_".$rto_name."_rto.xls";

$exp->exportWithPage("report_road_export_data.php", $rto_name);
?>