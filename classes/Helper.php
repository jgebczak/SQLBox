<?php

class Helper {

    static function shorten ($str,$length)
    {
        if (strlen($str) < $length) return $str;
        return substr($str, 0,$length).'...';
    }

}

?>