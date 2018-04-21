<?php
/**
 * Created by PhpStorm.
 * User: joseph
 * Date: 4/21/18
 * Time: 12:02 AM
 */
include('CommonMethods.php');
$debug = False;

$COMMON = new Common($debug);

$sql = <<< SQL
    SELECT * FROM `ParkingLot`;
SQL;
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$total = $rs->rowCount();

echo $total;


