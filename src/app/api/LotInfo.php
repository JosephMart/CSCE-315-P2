<?php
/**
 * File:    LotInfo.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * LotInfo Endpoint - get specific data about a particular lot
 *
 */
include_once "Endpoints.php";
$route = getRouteName();
$body = getBody();
HandleRoute($route, $body);