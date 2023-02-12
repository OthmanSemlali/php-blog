<?php

require_once('model.php');
function redirect_to($new_location)
{
    header('location:' . $new_location);
    exit;
}



// Strip tags html and php and content if it's withing tags
function strip_tags_content($string)
{

    // remove Content within tags
    $string =  preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $string);

    // ----- remove HTML TAGs ----- 
    $string = preg_replace('/<[^>]*>/', '', $string);


    // ----- remove control characters ----- 
    $string = str_replace("\r", '', $string);
    $string = str_replace("\n", ' ', $string);
    $string = str_replace("\t", ' ', $string);
    // ----- remove multiple spaces ----- 
    $string = preg_replace('/ {2,}/', ' ', $string);
    return $string;
}



function myUrlEncode($string)
{
    $entities = array('+','%27', "%20","%2B","%3F","%21");
    $replacements = array("-", "°","-","+","?","!");


    $string = urlencode($string);
    return str_replace($entities, $replacements,$string);
}
