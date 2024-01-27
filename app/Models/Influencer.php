<?php

namespace App\Models;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Influencer\StoreInfluencerRequest;
use App\Http\Requests\Influencer\UpdateInfluencerRequest;
use App\Http\Resources\InfluencerCategoryResource;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Influencer extends Model
{
    use HasFactory;

    protected $table      = 'influencers';
    protected $primaryKey = 'infID';
    public    $timestamps = false;


    protected $fillable = [
        'userID',
        'agencyID',
        'platformUserName',
        'bannerPhoto',
        'fenocityPoint',
        'fenocitySaleCount',
        'bioVerifyCode',
        'infVerify',
        'statsVerify',
        'isInfDeleted',
        'taxPayer',
    ];
    protected $hidden   = [
        'userID',
        'bioVerifyCode',
        'infVerify',
        'statsVerify',
        'isInfDeleted',
        'taxPayer',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'userID', 'userID');
    }


    public function categories()
    {

        return $this->hasMany(InfluencerCategories::class, 'influencer_id', 'infID')->with('category');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'influencer_id', 'infID');
    }

    public function accountProperties(): HasMany
    {
        return $this->hasMany(InfAccountProperties::class, 'infID', 'infID')->with('platform');
    }

    public static function getAllInfluencer($limit = 10)
    {
        return Influencer::with(['user', 'categories', 'accountProperties'])->get()->take($limit);
    }


    public static function getById($infID)
    {
        $influencer = Influencer::find($infID);
        if ($influencer == null) {
            return false;
        }

        return $influencer;
    }

    public static function createInfluencer(StoreInfluencerRequest $request, $user)
    {

        $influencer = DB::table('influencers')->insertGetId([
                                                                'userID'            => $user,
                                                                'agencyID'          => $request->agencyID,
                                                                'platformUserName'  => $request->platformUserName,
                                                                'bannerPhoto'       => $request->bannerPhoto,
                                                                'bioVerifyCode'     => '$BVC' . Str::random(60),
                                                                'statsVerify'       => false,
                                                                'isInfDeleted'      => false,
                                                                'taxPayer'          => $request->taxPayer == 'true',
                                                                'fenocityPoint'     => 0.00,
                                                                'fenocitySaleCount' => 0,
                                                                'infVerify'         => false,

                                                            ]);
        if ($influencer == null) {
            throw new Exception('Influencer could not be created');
        }
        return $influencer;
    }

    public static function getInfluencerByCategory($categoryID)
    {

        $influencers = DB::select('SELECT i.userID,i.infID,i.platformUserName,i.fenocitySaleCount,u.nameSurname,u.email,u.profilePhoto,u.userType
                FROM (SELECT userID, infID, platformUserName, fenocitySaleCount FROM influencers WHERE infID IN(SELECT influencer_id FROM influencers_categories WHERE category_id = ?) order by infID) as i
                JOIN users u ON u.userID = i.userID',
                                  [$categoryID]);

        if ($influencers == null) {
            return false;
        }
        return $influencers;
    }

    public static function updateInfluencer(UpdateInfluencerRequest $request, $id)
    {

        if ($id != null) {
            $influencer = Influencer::findOrFail($id);

            $influencer->agencyID          = $request->agencyID ?? $influencer->agencyID;
            $influencer->platformUserName  = $request->platformUserName ?? $influencer->platformUserName;
            $influencer->bannerPhoto       = $request->bannerPhoto ?? $influencer->bannerPhoto;
            $influencer->fenocityPoint     = $request->fenocityPoint ?? $influencer->fenocityPoint;
            $influencer->fenocitySaleCount = $request->fenocitySaleCount ?? $influencer->fenocitySaleCount;
            $influencer->infVerify         = $request->infVerify ?? $influencer->infVerify;
            $influencer->statsVerify       = $request->statsVerify ?? $influencer->statsVerify;
            $influencer->taxPayer          = $request->taxPayer ?? $influencer->taxPayer;
            $isSuccess                     = $influencer->save();
            if ($isSuccess) {
                return $influencer;
            }
            return throw new Exception('Influencer could not be updated');

        } else {
            return throw new Exception('Token is not valid');
        }


    }

}


