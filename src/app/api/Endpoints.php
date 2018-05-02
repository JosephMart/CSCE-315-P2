<?php
/**
 * File:    Endpoints.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * Endpoint Handlers and Actions
 *
 */
include_once "Queries.php";

/**
 * ENDPOINTS
 *
 * Maps /api/REQUEST.php to the appropriate REQUEST Function
 * Mapping a string to a function. Function name is a string but callable because PHP can so PHP will
 */
$ENDPOINTS = [
    "LotInfo" => "LotInfo",
    "OverallData" => "OverallData",
    "Lots" => "Lots",
    "LotPrediction" => "LotPrediction",
    "AddVehicle" => "AddVehicle",
    "ExitingVehicle" => "ExitingVehicle",
    "AddLot" => "AddLot",
    "RemoveLot" => "RemoveLot",
];

/* Endpoints Handlers */

/**
 * GetOverallLotData for a single `lotId`
 * @param array $body
 *  - keys:
 *      `lotId`: Lot DB ID to get data for
 *      `start`: start date for data to be fetched for
 *      `end`: end date for data to be fetched for
 * @return string
 */
function LotInfo($body)
{
    $LOT_ID = $body['lotId'];
    $start = $body['start'];
    $end = $body['end'];
    return json_encode(GetOverallLotData($LOT_ID, $start, $end));
}


/**
 * Get Overall Stats and Week graph data
 * @return string
 */
function OverallData()
{
    return json_encode(GetOverallData());
}

/**
 * Get All Lot Info that are in DB (name, id, created date)
 * @return string
 */
function Lots()
{
    return json_encode(GetLots());
}

/**
 * Generate lot prediction model
 * @param array $body
 *  - keys:
 *      `startDate`: start date for data to be fetched for
 *      `endDate`: end date for data to be fetched for
 *      `lotId`: Lot DB ID to get data for
 *      `'dayIndex`: DB day index where 1 - Sunday 7 - Saturday
 * @return string
 */
function LotPrediction($body)
{
    $startDate = $body["startDate"];
    $endDate = $body["endDate"];
    $lotId = $body["lotId"];
    $dayIndex = $body["dayIndex"];

    $data = LotPredictionQuery($lotId, $dayIndex, $startDate, $endDate);

    return json_encode(["data" => $data]);
//    return json_encode($startDate);
}

/**
 * Entering vehicle
 * @param array $body
 *  - keys:
 *      `lotId`: Lot DB ID to add vehicle to
 * @return int
 */
function AddVehicle($body)
{
    $LOT_ID = $body["lotId"];
    VehicleEntering($LOT_ID);
    return json_encode([
        "status" => "success"
    ]);
}

/**
 * Exiting vehicle
 * @param array $body
 *  - keys:
 *      `lotId`: Lot DB ID to add vehicle to
 * @return int
 */
function ExitingVehicle($body)
{
    $LOT_ID = $body["lotId"];
    VehicleExiting($LOT_ID);
    return json_encode([
        "status" => "success"
    ]);
}

/**
 * Add Lot
 * @param array $body
 * @return int
 */
function AddLot($body)
{
    $LOT_NAME = $body["lotName"];
    InsertLot($LOT_NAME);
    return json_encode([
        "status" => "success"
    ]);
}

/**
 * Remove Lot
 * @param array $body
 * @return int
 */
function RemoveLot($body)
{
    $LOT_ID = $body["lotId"];
    DeleteLot($LOT_ID);
    return json_encode([
        "status" => "success"
    ]);
}

/* Util Functions */

/**
 * Given the route, runs the appropriate function passing the body of the request
 * @param string $route
 * @param array $body
 */
function HandleRoute($route, $body)
{
    global $ENDPOINTS;

    try {
        echo $ENDPOINTS[$route]($body);
    } catch (Exception $e) {
        http_response_code(404);
        die();
    }
}

/**
 * Get the route name from the URI striping out the path and .php portion of the URI
 * @return string
 */
function getRouteName()
{
    return basename($_SERVER['REQUEST_URI'], ".php");
}

/**
 * Get the body of the request
 * @return mixed
 */
function getBody()
{
    return json_decode(file_get_contents('php://input'), true);
}
