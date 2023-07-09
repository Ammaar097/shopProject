<?php

function redirection($path)
{
   
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/shopProject$path";
    $url = 'Location: ' . $actual_link;
    header($url);
    exit();
}
