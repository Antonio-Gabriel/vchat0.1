<?php

namespace Vchat\Validators;

class Middleware
{
    public static function hasAuthenticated()
    {
        if (!isset($_SESSION["user_id"])) {
            redirect("/auth");
        }
    }

    public static function checkAuthentication()
    {
        if (isset($_SESSION["user_id"])) {
            redirect("/backoffice");
        }
    }
}
