<?php

if( ! function_exists('str_clickable'))
{
    function str_clickable($str) {
        return \Privateer\Clickable\Clickable::parse($str);
    }
}