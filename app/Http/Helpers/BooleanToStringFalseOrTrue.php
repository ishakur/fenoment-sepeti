<?php
namespace App\Http\Helpers;

class BooleanToStringFalseOrTrue
{
    /**
     * @param bool $value
     * @return string
     */
    public static function toString(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}