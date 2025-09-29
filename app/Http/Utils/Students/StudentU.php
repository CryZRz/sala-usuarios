<?php

namespace App\Http\Utils\Students;

use Ramsey\Uuid\Uuid;

class StudentU{
    private const BASE_UUID = "6ba7b810-9dad-11d1-80b4-00c04fd430c8";
    public static function makeUUID(string $key)
    {
        $namesPaceUuidObject = Uuid::fromString(self::BASE_UUID);

        return UUID::uuid5($namesPaceUuidObject, $key);
    }

    public static function unaccentedText($text)
    {
        $accents = [
            'á' => 'a', 'Á' => 'A',
            'é' => 'e', 'É' => 'E',
            'í' => 'i', 'Í' => 'I',
            'ó' => 'o', 'Ó' => 'O',
            'ú' => 'u', 'Ú' => 'U',
            'ü' => 'u', 'Ü' => 'U',
        ];

        return strtr($text, $accents);
    }

}
