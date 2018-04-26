<?php
include_once "CommonMethods.php";
$COMMON = new Common(false);

/**
 * Calculate the mode of an int array
 * @param $values array
 * @return false|int|string
 */
function CalculateMode($values) {
    $counts = array_count_values($values);

    if (max($counts) == 1) {
        return 'No repeating values';
    }
    return array_search(max($counts), $counts);
}

/**
 * Calculate the median of an int array
 * @param $values array
 * @return float|int
 */
function CalculateMedian($values) {
    $count = sizeof($values);
    $midVal = (int)floor(($count-1)/2);

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
    $result["medianIn"] = CalculateMedian($inValues);
    $result["medianOut"] = CalculateMedian($outValues);

    // Calculate Mode
    $result["modeIn"] = CalculateMode($inValues);
    $result["modeOut"] = CalculateMode($outValues);

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
