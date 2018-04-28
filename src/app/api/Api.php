<?php
include_once "Queries.php";
$ROUTE = strtolower(str_replace(['/api/', '.php'],'', $_SERVER['PHP_SELF']));

function alots() {
    echo json_encode(GetLots());
}

$ENDPOINTS = [
    "lots" => 'alots'
];

function foo() { echo "bar"; }
$array = array('Lots' => 'alots');

//$t = $ENDPOINTS[$ROUTE];
//echo $array[$ROUTE]();
echo str_replace(['.php'], '', $_SERVER['PHP_SELF']);