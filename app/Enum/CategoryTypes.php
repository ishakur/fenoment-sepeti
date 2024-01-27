<?php

namespace App\Enum;

class CategoryTypes
{
    public static function cases()
    {
        return [
            self::All,
            self::Sports,
            self::Fashion,
            self::Meal,
            self::Technology,
            self::Wear,
            self::Makeup,
            self::Furniture,
        ];
    }

    const All     = "All";
    const Sports  = "Sports";
    const Fashion = "Fashion";

    const Meal       = "Meal";
    const Technology = "Technology";
    const Wear       = "Wear";
    const Makeup     = "Makeup";
    const Furniture  = "Furniture";
}