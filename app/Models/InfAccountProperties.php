<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InfAccountProperties extends Model
{
    public    $timestamps = false;
    protected $table      = 'influencer_account_properties';
    protected $primaryKey = 'infAccPropID';
    use HasFactory;

    protected $fillable = [
        'infID',
        'platformID',
        'platformUserName',
        'followerCount',
        'followingCount',
        'mediaCount',
        'avarageLikeCount',
        'avarageViewCount',
        'storyViewCount',
        'reachedAccountCount',
        'enagagedAccountCount',
        'saveCount',
        'shareCount',
        'socialVerify'
    ];

    public function influencer(): HasOne
    {
        return $this->hasOne(Influencer::class, 'userID', 'infID');
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class, 'platformID');
    }
}
