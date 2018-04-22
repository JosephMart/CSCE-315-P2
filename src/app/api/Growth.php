<?php
include_once "CommonMethods.php";
$hourly_rate = 123;
$lot_num = "31";
$growth_rate = 0.033;



$debug = false;

$COMMON = new Common($debug);

// SQL statement for data
$sql = <<< SQL
    SELECT * FROM `ParkingLot`;
SQL;

// Execute query
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

$data = [["Year","3.3% GR","2% GR","5% GR","10% GR"]];
//TODO: Fix year chart axis
for($x = 0; $x <= 7; $x++){
	array_push($data, [(string)2018+$x,$hourly_rate*(pow(M_E,$growth_rate*$x)),$hourly_rate*(pow(M_E,.02*$x)),$hourly_rate*(pow(M_E,.05*$x)),$hourly_rate*(pow(M_E,.1*$x))]);
}


// Respond to the request
header('Content-type: application/json');
echo json_encode($data);