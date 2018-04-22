<?php
include_once "CommonMethods.php";

$req = json_decode(file_get_contents('php://input'), true);

$COMMON = new Common(false);

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
echo json_encode([
    "title" => "Awesome Header",
    "data" => $data
]);