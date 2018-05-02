<?php
/**
 * File:    RemoveLot.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * Remove Lot
 *
 */
include_once "Endpoints.php";
$route = getRouteName();
$body = getBody();
HandleRoute($route, $body);