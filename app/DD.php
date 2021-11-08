<?php

namespace App;

class DD
{
    public static function dd($data): void
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die;
    }

    public static function dump($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}