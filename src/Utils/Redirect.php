<?php

function redirect($route)
{
    header("Location: {$_ENV["BASE_URL"]}{$route}");
    die();
}
