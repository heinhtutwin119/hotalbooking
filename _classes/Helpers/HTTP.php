<?php

namespace Helpers;

class HTTP 
{
    static $base = "http://localhost/hotalbooking";

    static function redirect($page , $q = "") 
    {
        $url = static :: $base . $page;
        if($q) $url .= "?$q";
        header("location: $url");
        exit();
    }
}

// HTTP::redirect("/index.php");
// HTTP::redirect("/index.php" . "http=test");