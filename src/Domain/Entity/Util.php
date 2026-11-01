<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Util
{
    public static function dd(mixed $var): void
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
        die();
    }
}
