<?php

namespace Vchat\Entities;

class User
{
    public function getSessionId()
    {
        return session_id();
    }

    public function isAuthUser()
    {
        if (!isset($_SESSION["user_id"])) {
            return false;
        }
    }

    public function getUserID()
    {
        return $_SESSION["user_id"];
    }
}
