<?php
/**
 * File:    OverallData.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * OverallData Endpoint - get general overall data about the project
 *
 */
include_once "Endpoints.php";
$route = getRouteName();
$body = getBody();
HandleRoute($route, $body);