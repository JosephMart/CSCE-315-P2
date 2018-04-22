<?php
include_once "CommonMethods.php";

$debug = False;

$COMMON = new Common($debug);

// SQL statement for data
$sql = <<< SQL
    SELECT * FROM `ParkingLot`;
SQL;

// Execute query
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

$data = [
    ['Year', 'Sales', 'Expenses'],
    ['2004', 1000, 400],
    ['2005', 1170, 460],
    ['2006', 660, 1120],
    ['2007', 1030, 540]
];

// Respond to the request
header('Content-type: application/json');
echo json_encode($data);