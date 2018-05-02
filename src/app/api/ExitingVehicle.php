<?php
/**
 * File:    ExitingVehicle.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * Exiting Vehicle
 *
 */
include_once "Endpoints.php";
$route = getRouteName();
$body = getBody();
HandleRoute($route, $body);