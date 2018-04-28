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
    "LotPrediction" => "LotPrediction"
];

/* Endpoints Handlers */

/**
 * GetOverallLotData for a single `lotId`
 * @param $body ArrayObject
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

function LotPrediction($body)
{
    $LOT_ID = $body["lotId"];
    return $LOT_ID;
}

/* Util Functions */

/**
 * Given the route, runs the appropriate function passing the body of the request
 * @param $route
 * @param $body
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
