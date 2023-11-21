<?php

namespace traits;

trait SecurityController
{
    public function is_connect()
    {
        if (isset($_SESSION["user"])) {
            return true;
        } else {
            return false;
        }
    }
    public function is_connectAdmin()
    {
        if (isset($_SESSION["admin"])) {
            return true;
        } else {
            return false;
        }
    }
}
