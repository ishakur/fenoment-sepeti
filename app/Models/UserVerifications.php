<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerifications extends Model
{
    use HasFactory;

    protected $table      = 'user_verifications';
    protected $primaryKey = 'userID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userID',
        'email',
        'phoneNumber',
        'eMailVerify',
        'phoneVerify',
        'eMailVerifyDate',

        'phoneVerifyDate',
        'lastLoginDate',
        'registerDate',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'eMailVerifyDate',
        'phoneVerifyDate',
        'phoneVerifyCode',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phoneVerifyDate'   => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eMailVerify()
    {
        $this->eMailVerify     = 1;
        $this->eMailVerifyDate = now();
        $this->save();
    }
}
