<?php
/**
 * Created by PhpStorm.
 * User: joseph
 * Date: 4/21/18
 * Time: 2:40 PM
 */

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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/main.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="/assets/js/main.js"></script>
    </head>
HTML;
}