<?php
/**
 * File:    Queries.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * Functions that Handle Database Queries and
 * Interaction
 *
 */

include_once "CommonMethods.php";
$COMMON = new Common(false);

function VehicleEntering($lotid) {
    global $COMMON;

    $sql = <<< SQL
    INSERT INTO `Vehicle` (`id`, `time`, `entering`, `lot_id`)
    VALUES (NULL, CURRENT_TIMESTAMP, '1', {$lotid});
SQL;
    $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

}

function VehicleExiting($lotid) {
    global $COMMON;

    $sql = <<< SQL
    INSERT INTO `Vehicle` (`id`, `time`, `entering`, `lot_id`)
    VALUES (NULL, CURRENT_TIMESTAMP, '0', {$lotid});
SQL;
    $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

function DeleteLot($lotid) {
    global $COMMON;

    $sql = <<< SQL
    DELETE from `ParkingLot`
    WHERE id = {$lotid};
SQL;
    $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

function InsertLot($lotName) {
    global $COMMON;

    $sql = <<< SQL
    INSERT INTO `ParkingLot` (`id`, `name`, `created_date`)
    VALUES (NULL, '{$lotName}', CURRENT_TIMESTAMP);
SQL;
    $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

function LotPredictionQuery($lotId, $dayIndex, $startDate, $endDate) {
    global $COMMON;

    $sql = <<< SQL
    SELECT
      SUM(
          CASE WHEN entering = 1 THEN 1 ELSE 0 END
      ) AS entering,
      SUM(
          CASE WHEN entering = 0 THEN 1 ELSE 0 END
      ) AS exiting,
      DATE_FORMAT(time, '%H:00') AS date
    FROM Vehicle
    WHERE lot_id = {$lotId} AND DAYOFWEEK(time) = {$dayIndex} AND time >= '{$startDate}' AND time <= '{$endDate}'
    GROUP BY date
    ORDER BY date;
SQL;
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return $rs->fetchAll();
//    return $sql;
}


/**
 * Calculate the mode of an int array
 * @param $values array
 * @return false|int|string
 */
function FindMode($values) {
    $counts = array_count_values($values);
    return (max($counts) == 1) ? "No Mode" : array_search(max($counts), $counts);
}

/**
 * Calculate the median of an int array
 * @param $values array
 * @return float|int
 */
function FindMedian($values) {
    $count = sizeof($values);
    $middleIndex = (int)floor(($count-1)/2);

    if($count % 2) {
        $median = $values[$middleIndex];
    } else {
        $low = $values[$middleIndex];
        $high = $values[$middleIndex+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

/**
 * Calculate analysis data of provided query
 * @param $subQuery string - with entering and exiting annotated as values
 * @param $data array
 * @return mixed
 */
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
    $result = $rs->fetch();

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
    $result["medianIn"] = FindMedian($inValues);
    $result["medianOut"] = FindMedian($outValues);

    // Calculate Mode
    $result["modeIn"] = FindMode($inValues);
    $result["modeOut"] = FindMode($outValues);

    return $result;
}

/**
 * Get Overall Stats and Week graph data
 * @return array
 */
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

/**
 * GetLotInfo - general function to get lot info
 * @param $timeFormat string
 * @param $lotId int
 * @param $start string
 * @param $end string
 * @return array
 */
function GetLotInfo($timeFormat, $lotId, $start, $end)
{
    global $COMMON;

    $whereStatement = '';

    if(isset($start) && isset($end)) {
        $whereStatement = <<< SQL
        AND time >= '{$start}' AND time <= '{$end}'
SQL;
    }

    $sql = <<< SQL
    SELECT
        L.name as lotName,
        SUM(
          CASE WHEN entering = 1 THEN 1 ELSE 0 END
        ) AS entering,
        SUM(
          CASE WHEN entering = 0 THEN 1 ELSE 0 END
        ) AS exiting,
        DATE_FORMAT(time, '{$timeFormat}') as date
    FROM
      Vehicle
    INNER JOIN ParkingLot L on Vehicle.lot_id = L.id
    WHERE Vehicle.lot_id = {$lotId} {$whereStatement}
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
        "data" => $data,
        "lotName" => $lotName
    ];
}

/**
 * Lot info on a Week basis
 * @param $lotId int
 * @param $startDate string
 * @param $endDate string
 * @return array
 */
function LotByWeek($lotId, $startDate, $endDate)
{
    return GetLotInfo('%Y-%U', $lotId, $startDate, $endDate);
}


/**
 * Lot info on a Day basis
 * @param $lotId int
 * @param $startDate string
 * @param $endDate string
 * @return array
 */
function LotByDay($lotId, $startDate, $endDate)
{
    return GetLotInfo('%Y-%m-%d', $lotId, $startDate, $endDate);
}

/**
 * Lot info on a Hour basis
 * @param $lotId int
 * @param $startDate string
 * @param $endDate string
 * @return array
 */
function LotByHour($lotId, $startDate, $endDate)
{
    return GetLotInfo('%Y-%m-%d %H:00', $lotId, $startDate, $endDate);
}

/**
 * Lot info
 * @param $lotId int
 * @param $startDate string
 * @param $endDate string
 * @return array
 */
function GetOverallLotData($lotId, $startDate, $endDate)
{
    return [
        "analysis" => LotByHour($lotId, $startDate, $endDate)["analysis"],
        "dayGraph" => LotByHour($lotId, $startDate, $endDate)["data"],
        "lotName" => LotByHour($lotId, $startDate, $endDate)["lotName"]
    ];
}

/**
 * Get all data from ParkingLot table
 * @return array
 */
function GetLots()
{
    global $COMMON;

    $sql = <<< SQL
    SELECT * FROM ParkingLot
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return $rs->fetchAll();
}
