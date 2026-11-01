<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Util
{
    public static function dd(mixed $var, bool $dump = false): void
    {
        echo "<pre>";
        if ($dump) {
            var_dump($var);
        } else {
            print_r($var);
        }

        echo "</pre>";
        die();
    }
}
