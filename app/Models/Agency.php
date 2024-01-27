<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;


    protected $table = 'agencies';
    protected $primaryKey = 'agencyID';
    protected $fillable = [
        'userID',
        'agencyName',
        'agencyAddress',
        'taxNumber',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'users','userID', 'userID');
    }
    public function userVerifications()
    {
        return $this->hasMany(UserVerifications::class, 'userID', 'userID');
    }
}
