<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enum\OrderStatus;
use App\Enum\UserTypes;
use App\Exceptions\NotFound;
use App\Exceptions\SystemException;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUser;
use App\Notifications\ResetPasswordNotification;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public    $timestamps = false;
    protected $table      = 'users';
    protected $primaryKey = 'userID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userID',
        'nameSurname',
        'password',
        'profilePhoto',
        'balance',
    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'userID',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getId()
    {
        return $this->userID;
    }

    public function eMailVerify()
    {
        $this->userVerifications->eMailVerify     = 1;
        $this->userVerifications->eMailVerifyDate = now();
        $this->userVerifications->save();
    }

    public function getMyOrders()
    {
        return $this->hasMany(OrderDetails::class, 'purchaser_id', 'userID')->limit(5);
    }

    public function currentBasket()
    {
        return $this->hasOne(OrderDetails::class, '', 'userID')->where('status', OrderStatus::OnChart);
    }

    public function getMyOrderById()
    {
        return $this->hasOne(OrderDetails::class, 'purchaser_id', 'userID')->select('id');
    }

    public function getMyOrderItemById()
    {
        return $this->hasOne(OrderItems::class, 'buyer_id', 'userID')->select('id');
    }

    public function userVerifications()
    {
        return $this->hasOne(UserVerifications::class, 'userID', 'userID');
    }

    public function userTemporaryVerificationCodes()
    {
        return $this->hasOne(UserTemporaryVerificationCodes::class, 'userID', 'userID');
    }


    public function isEmailVerify(): bool
    {
        return UserVerifications::where('userID', $this->userID)->first()->eMailVerify;
    }

    public function isAdmin(): bool
    {
        return $this->userType == UserTypes::Admin;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'userID'   => $this->userID,
            'userType' => $this->userType,
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $url = 'http://fenocity_email.test?password_reset_url=token=' . $token;
        $this->notify(new ResetPasswordNotification($url));
    }

    public function getUserType(): bool
    {
        return $this->userType;
    }

    public static function createUser(RegisterRequest $request)
    {

        $user               = new User();
        $user->userType     = $request->userType;
        $user->email        = $request->email;
        $user->nameSurname  = $request->nameSurname;
        $user->balance      = 0;
        $user->password     = bcrypt($request->password);
        $user->profilePhoto = $request->profilePhoto;

//        $user->profilePhoto = !empty($request->file('profilePhoto')) ? $request->file('profilePhoto')
//                                                                               ->store('profilePhoto') : 'profilePhoto/default.png';
        $user->save();


        $userVerifications              = new UserVerifications();
        $userVerifications->userID      = $user->userID;
        $userVerifications->phoneNumber = $request->phoneNumber ?? null;
        $userVerifications->googleId    = bcrypt($request->googleId) ?? null;
        $userVerifications->facebookId  = bcrypt($request->facebookId) ?? null;
        $userVerifications->appleId     = bcrypt($request->appleId) ?? null;

        $userVerifications->eMailVerify     = false;
        $userVerifications->phoneVerify     = false;
        $userVerifications->eMailVerifyDate = null;
        $userVerifications->phoneVerifyDate = null;
        $userVerifications->created_at      = now();

        $userVerifications->save();

        if (!$user)
            throw new NotFound(__('controller.user'));

        return $user;


    }

    public static function updateUser(UpdateUser $request)
    {
        $user = User::find($request->userID);

        if (!$user)
            throw new NotFound('user');

        $user->email        = $request->email != null ? $request->email : $user->email;
        $user->nameSurname  = $request->nameSurname != null ? $request->nameSurname : $user->nameSurname;
        $user->password     = $request->password != null ? bcrypt($request->password) : $user->password;
        $user->profilePhoto = $request->profilePhoto != null ? $user->profilePhotoAdd : $user->profilePhoto;
        $user->save();


        $userVerifications = UserVerifications::where('userID', $user->userID)->first();
        if (!$userVerifications)
            throw new NotFound('userVerifications');

        $userVerifications->updated_at  = now();
        $userVerifications->phoneNumber = $request->phoneNumber != null ? $request->phoneNumber : $userVerifications->phoneNumber;
        //eger email degistirildiyse
        if ($user->email != $request->email) {
            //TODO burasi calismiyor
            $userVerifications->eMailVerify     = false;
            $userVerifications->eMailVerifyDate = null;
        } else if ($userVerifications->phoneNumber != $request->phoneNumber) {
            $userVerifications->phoneVerify     = false;
            $userVerifications->phoneVerifyDate = null;
        }

        if ($userVerifications->save() && $user->save())
            return $user;

        throw new Exception(ApiController::getTextFromControllerLanguageFile('updateFailed', 'user'));
    }

    public static function registerUpdate($request)
    {
        $userUpdate               = User::whereEmail($request->email)->first();
        $userUpdate->userType     = $request->userType;
        $userUpdate->nameSurname  = $request->nameSurname;
        $userUpdate->email        = $request->email;
        $userUpdate->password     = isset($request->password) ? bcrypt($request->password) : null;
        $userUpdate->profilePhoto = $request->profilePhoto;


        $userUpdate->save();

        $userVerifications             = UserVerifications::where('userID', $userUpdate->userID)->firstOrFail();
        $userVerifications->googleId   = bcrypt($request->googleId);
        $userVerifications->facebookId = bcrypt($request->facebookId);
        $userVerifications->updated_at = now();

        if ($userUpdate->email != $request->email) {
            $userVerifications->eMailVerify     = false;
            $userVerifications->eMailVerifyDate = null;
        }

        $userVerifications->save();

        if (!$userUpdate || !$userVerifications)
            return throw new Exception('User not updated');

        return $userUpdate;


    }

    public static function deleteUser($user)
    {
        if (isset($user)) {
//                dd($user);
//                $oldUserType    = UserTypes::cases()[$user->userType];
            $user->userType = UserTypes::Deleted;

            $isSuccess = $user->save();
            if (!$isSuccess) {
                return throw new Exception('User not deleted');
            } else {
//                    dd($user);
                return $user;
            }
        } else {
            return throw new Exception('User not found');
        }

    }

    public function changeProfilePhoto($request, $oldUserProfilePhotoPaths)
    {
        if ($request->hasFile('myfile')) {
            try {
                $storage    = new StorageClient([
                                                    'keyFilePath' => base_path() . 'JSON_KEY_FILENAME',
                                                ]);
                $bucketName = env('GOOGLE_CLOUD_BUCKET');
                $bucket     = $storage->bucket($bucketName);

                //get filename with extension
                $filenamewithextension = $request->file('myfile')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('myfile')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

                Storage::put('public/uploads/' . $filenametostore, fopen($request->file('myfile'), 'r+'));

                $filepath = storage_path('app/public/uploads/' . $filenametostore);

                $object = $bucket->upload(
                    fopen($filepath, 'r'),
                    [
                        'predefinedAcl' => 'publicRead',
                    ],
                );

                // delete file from local disk
                Storage::delete('public/uploads/' . $filenametostore);

                return redirect('upload')->with('success',
                                                "File is uploaded successfully. File path is: https://storage.googleapis.com/$bucketName/$filenametostore");

            } catch (Exception $e) {
                echo $e->getMessage();
            }

        }
    }
}

