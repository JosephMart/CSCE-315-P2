<?php
/**
 * File:    AddVehicle.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * Add a Vehicle to a lot
 *
 */
include_once "Endpoints.php";
$route = getRouteName();
$body = getBody();
HandleRoute($route, $body);