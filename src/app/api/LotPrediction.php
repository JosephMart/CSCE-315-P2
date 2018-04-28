<?php
/**
 * File:    LotPrediction.php
 * Project: CSCE 315 Project 2
 * Date:    04/28/2018
 *
 * Create Prediction Model
 *
 */
include_once "Endpoints.php";
$route = getRouteName();
$body = getBody();
HandleRoute($route, $body);