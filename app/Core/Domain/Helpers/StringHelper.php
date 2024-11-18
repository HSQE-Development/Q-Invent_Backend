<?php

namespace App\Core\Domain\Helpers;

class StringHelper
{
    public static function convertMinusculesWithoutTyldes(string $word)
    {
        $newStr = mb_strtolower($word);
        $newStr = strtr($newStr, 'áéíóúÁÉÍÓÚ', 'aeiouAEIOU');
        return $newStr;
    }
}
