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

/* Maps /api/Request.php to the Route Function */
$ENDPOINTS = [
    "LotInfo" => "LotInfo",
    "OverallData" => "OverallData",
    "Lots" => "Lots"
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

/* Util Functions */

/**
 * Given the route, runs the appropriate function passing the body of the request
 * @param $route
 * @param $body
 */
function HandleRoute($route, $body)
{
    global $ENDPOINTS;
    echo $ENDPOINTS[$route]($body);
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
