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

    <!-- Local CSS-->
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/main.css" />

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