<?php

namespace App\Enum;


class UserTypes
{
    public static function cases()
    {
        return [
            self::Banned,
            self::User,
            self::CorpAdvertiser,
            self::Influencer,
            self::Agency,
            self::Admin,
            self::Deleted,
        ];
    }

    const Banned = "Banned";

    const User = "User";

    const CorpAdvertiser = "CorpAdvertiser";

    const Influencer = "Influencer";

    const Agency  = "Agency";
    const Admin   = "Admin";
    const Deleted = "Deleted";


}
