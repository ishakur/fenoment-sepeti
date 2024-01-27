<?php

namespace App\Enum;

class PlatformTypes
{
    public static function cases()
    {
        return [
            self::Instagram,
            self::Tiktok,
            self::Youtube,
            self::Twitter,
            self::Facebook,
            // self::Apple,
            // self::Google,
        ];
    }

    const   Instagram = 'Instagram';
    const   Tiktok    = 'Tiktok';
    const   Youtube   = 'Youtube';
    const   Twitter   = 'Twitter';
    const   Facebook  = 'Facebook';
    // const   Apple     = 'Apple';

    // const Google = 'Google';


}
