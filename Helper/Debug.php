<?php

class Debug
{
    static function dd($arr)
    {
        $css = file_get_contents('vendor/css/app.css');

        echo "<style>" . $css . "</style>";

        echo "<div class='debug'><pre>";
        print_r($arr);
        echo "</pre></div>";
    }
}
