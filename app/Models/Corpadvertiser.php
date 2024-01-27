<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corpadvertiser extends Model
{
    use HasFactory;
    protected $table = 'corporate_advertisers';

    public $timestamps = false;

    protected $fillable = [
        'corpAdvID',
        'userID',
        'corpAdvName',
        'corpAdvAddress',
        'taxNumber',

    ];
    public function user()
    {
        return $this->hasOne(User::class, 'userID', 'userID');
    }

    public function userVerifications(): HasMany
    {
        return $this->hasMany(UserVerifications::class, 'userID', 'userID');
    }
}