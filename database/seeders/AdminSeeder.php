<?php

namespace Database\Seeders;

use App\Enum\UserTypes;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Influencer;
use App\Models\Product;
use App\Models\User;
use App\Models\UserVerification;
use App\Models\UserVerifications;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setForeignKeyCheckOff();
        User::truncate();
        UserVerifications::truncate();

        //tum adminler olusturuluyor
        $admins = [
            [
                'nameSurname' => 'Faruk Aydogan',
                'email'       => 'developer@farukaydogan.com',
                'phoneNumber' => '5323466400',
            ],
            [
                'nameSurname' => 'Nisa Kayahan',
                'email'       => 'nisakayahan6@icloud.com',
                'phoneNumber' => '5324564472',
            ],
            [
                'nameSurname' => 'Emre Kutan Nural',
                'email'       => 'emrenural.elk@gmail.com',
                'phoneNumber' => '5535174040',
            ],
            [
                'nameSurname' => 'Ibrahim Furkan Ozkan',
                'email'       => 'barbrrsdern@gmail.com',
                'phoneNumber' => '5392698846',
            ],

        ];


        try {
            foreach ($admins as $admin) {
                $user               = new User();
                $user->nameSurname  = $admin['nameSurname'];
                $user->email        = $admin['email'];
                $user->password     = bcrypt("Secret1*");
                $user->profilePhoto = "https://storage.googleapis.com/user_profile_photo/admin.png";
                $user->balance      = 99999;
                $user->userType     = UserTypes::Admin;
                $user->save();

                $userVerifications= new UserVerifications();
                $userVerifications->userID=$user->id;

                $userVerifications->phoneNumber = $admin['phoneNumber'];
                $userVerifications->eMailVerify = true;
                $userVerifications->phoneVerify                      = true;
                $userVerifications->eMailVerifyDate                  = now();
                $userVerifications->phoneVerifyDate                  = now();
                $userVerifications->lastLoginDate                    = now();
                $userVerifications->registerDate                     = now();
                $user->userVerifications()->save($userVerifications);
            }


        } catch (Exception $e) {
            echo $e->getMessage();
        }


        $this->setForeignKeyCheckOn();

    }
}
