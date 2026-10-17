<?php

namespace Helpers;

class Auth 
{
    static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['user']) ) {
            return $_SESSION['user'];
        }
        HTTP::redirect("/index.php", "auth=fail");
    }
}