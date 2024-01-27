<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  UserTemporaryVerificationCodes extends Model
{
    use HasFactory;

    protected $table = 'user_temporary_verification_codes';

    protected $fillable = [
        'userId',
        'code',
        'expire_date',
    ];

}
