<?php
/**
 * HtmlHeader
 * @param $title string Title of the page
 * @return string default HTML <head>
 */
function HtmlHeader($title)
{
    return <<< HTML
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>P2|{$title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Bootstrap CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

    <!-- Local CSS-->
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/main.css" />
    
    <!-- Bootstrap JSS-->
    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <!-- Local JS-->
    <script src="/assets/js/main.js"></script>
</head>
HTML;
}

/**
 * Sidebar
 * @return string
 */
function Sidebar() {
    return <<< HTML
    <div id="mySidenav" class="hidden">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="/">Home</a>
        <a href="#">Admin</a>
    </div>
    <nav class="nav">
        <ul>
             <li><span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span></li>
             <li><h1>Vehicle Garage Counter</h1></li>   
        </ul>
    </nav>
HTML;
}