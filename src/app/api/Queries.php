<?php
include_once "CommonMethods.php";
$COMMON = new Common(false);


function CalculateMode($values) {
    $counts = array_count_values($values);

    if (max($counts) == 1) {
        return 'No repeating values';
    }
    return array_search(max($counts), $counts);
}

function CalculateMedian($values) {
    $count = sizeof($values);
    $midVal = floor(($count-1)/2);

    // Calculate median based on if even or odd number of items
    if($count % 2) {
        $median = $values[$midVal];
    } else {
        $low = $values[$midVal];
        $high = $values[$midVal+1];
        $median = (($low+$high)/2);
    }
    return $median;
}


function AnalyzeQuery($subQuery, $data)
{
    global $COMMON;

    // Analysis queries
    $sql = <<< SQL
    SELECT 
        SUM(entering) as totalIn, 
        AVG(entering) as averageIn, 
        MIN(entering) as minIn, 
        MAX(entering) as maxIn,
        SUM(exiting) as totalOut, 
        AVG(exiting) as averageOut, 
        MIN(exiting) as minOut, 
        MAX(exiting) as maxOut
    FROM ({$subQuery}) as sub;
SQL;
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    $result = $rs->fetchAll()[0];

    $inValues = array();
    $outValues = array();

    // Get Values in array format
    for ($i = 0; $i < sizeof($data); $i++) {
        array_push($inValues, (int)$data[$i]['entering']);
        array_push($outValues, (int)$data[$i]['exiting']);
    }

    // Sort Value from lowest to highest
    sort($inValues);
    sort($outValues);

    // Calculate Median
    $result["medianIn"] = CalculateMedian($inValues);
    $result["medianOut"] = CalculateMedian($outValues);

    // Calculate Mode
    $result["modeIn"] = CalculateMode($inValues);
    $result["modeOut"] = CalculateMode($outValues);

    return $result;
}

function GetOverallData()
{
    global $COMMON;

    $sql = <<< SQL
    SELECT
        SUM(
          CASE WHEN entering = 1 THEN 1 ELSE 0 END
        ) AS entering,
        SUM(
          CASE WHEN entering = 0 THEN 1 ELSE 0 END
        ) AS exiting,
        DATE_FORMAT(time, '%Y-%m-%d') AS date
    FROM
      Vehicle
    GROUP BY date
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    $data = $rs->fetchAll();
    return [
        "analysis" => AnalyzeQuery($sql, $data),
        "graphData" => $data
    ];
}

function GetOverallLotData($lotId)
{
    global $COMMON;

    $sql = <<< SQL
    SELECT
        L.name as lotName,
        SUM(
          CASE WHEN entering = 1 THEN 1 ELSE 0 END
        ) AS entering,
        SUM(
          CASE WHEN entering = 0 THEN 1 ELSE 0 END
        ) AS exiting,
        DATE_FORMAT(time, '%Y-%m-%d') AS date
    FROM
      Vehicle
    INNER JOIN ParkingLot L on Vehicle.lot_id = L.id
    WHERE Vehicle.lot_id = {$lotId}
    GROUP BY date
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    $data = $rs->fetchAll();
    $lotName = "";

    if ($data) {
        $lotName = $data[0]["lotName"];
    }
    return [
        "analysis" => AnalyzeQuery($sql, $data),
        "graphData" => $data,
        "lotName" => $lotName
    ];
}

function GetLots()
{
    global $COMMON;

    $sql = <<< SQL
    SELECT *
    FROM
      ParkingLot
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return $rs->fetchAll();
}
