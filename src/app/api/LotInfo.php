<?php
include_once "Queries.php";
$req = json_decode(file_get_contents('php://input'), true);
$LOT_ID = $req['lotId'];

echo json_encode(GetOverallLotData($LOT_ID));