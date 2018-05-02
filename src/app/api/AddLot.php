<?php
/**
 * File:    AddLot.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * Add a new lot
 *
 */
include_once "Endpoints.php";
$route = getRouteName();
$body = getBody();
HandleRoute($route, $body);