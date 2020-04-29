<?php

namespace App\Model;

abstract class AbstractBase
{
    public static function getPrettyFormatValueInString(?int $value) : string
    {
        $result = '0';
        if ($value) {
            $value = floatval($value);
            $result = number_format($value, 0, ',', '.');
        }

        return $result;
    }
}
