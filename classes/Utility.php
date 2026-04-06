<?php

class Utility
{
    public static function is_email($email)
    {
        $rsp = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($rsp === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function sanitize($evil_string)
    {
        $safe_string = strip_tags($evil_string);
        $safe_string = htmlentities($safe_string);

        return $safe_string;
    }

    public static function generate_ref()
    {
        return uniqid();
    }
}
