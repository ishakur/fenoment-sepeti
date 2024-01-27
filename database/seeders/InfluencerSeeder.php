<?php

namespace Database\Seeders;

use App\Enum\CategoryTypes;
use App\Enum\PlatformTypes;
use App\Enum\UserTypes;
use App\Models\InfAccountProperties;
use App\Models\Influencer;
use App\Models\InfluencerCategories;
use App\Models\Product;
use App\Models\ProductProperties;
use App\Models\User;
use App\Models\UserVerifications;
use Faker\Generator;
use Illuminate\Container\Container;


class InfluencerSeeder extends SeederHelper
{
    /**
     * birbirine bagimli olduklari icin influencerdan donen id ile influencerCategory olusturuluyor
     * olusturulan influencerlarida product haline getirip kullaniyorz
     *
     * @return void
     */
    public function run()
    {
        //
        $this->setForeignKeyCheckOff();
        //kullanilan tum tablolar temizleniyor
        Influencer::truncate();
        InfluencerCategories::truncate();
        InfAccountProperties::truncate();
        Product::truncate();
        ProductProperties::truncate();

        $faker = Container::getInstance()->make(Generator::class);

        //real influencer bilgileri
        $influencersData = [
            ['nameSurname' => 'Berkcan Güven', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/berkcan_guven.jpg'],
            ['nameSurname' => 'Duygu Özaslan', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/duygu_ozaslan.jpg'],
            ['nameSurname' => 'Ecmel Soylu', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/ecmelsoylu.jpg'],
            ['nameSurname' => 'Elanur Bela', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/elanur.jpg'],
            ['nameSurname' => 'Enes Batur', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/enes_batur.jpg'],
            ['nameSurname' => 'Eylül Bahar', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/eylul_bahar.jpg'],
            ['nameSurname' => 'Gamze', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/gamzePP.jpeg'],
            ['nameSurname' => 'Nusr Et', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/nusr_et.jpg'],
            ['nameSurname' => 'Oğuzhan Uğur', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/oguzhan_ugur.jpg'],
            ['nameSurname' => 'Pelin Akıl', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/pelin_akil.jpg'],
            ['nameSurname' => 'Uberkuloz', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/seyda_erdogan.jpg'],
            ['nameSurname' => 'Şeyda Erdoğan', 'profilePhoto' => 'https://storage.googleapis.com/user_profile_photo/influencer/uberkuloz.jpg'],

        ];

        //urunler olusturulmadan property olusturuyoruz cunku property nin id si urun olusturulurken kullaniliyor
        $productNames = ['Reels', 'Story', 'Post', 'Live'];
        for ($i = 0; $i < count(PlatformTypes::cases()); $i++) {
            for ($j = 0; $j < count($productNames); $j++) {
                ProductProperties::create([
                                              'property_name' => $productNames[$j],
                                              'platform_id'   => $i + 1,
                                          ]);
            }
        }

        //10 adet influencer olusturuluyor
        for ($i = 0; $i < count($influencersData); $i++) {
            //oncelilkle influencerin useri olusturuluyor
            $user = User::create([
                                                'userType'     => UserTypes::Influencer,
                                                'profilePhoto' => $influencersData[$i]['profilePhoto'],
                                                'nameSurname'  => $influencersData[$i]['nameSurname'],
                                                'email'        => $faker->safeEmail(),
                                                'password'     => bcrypt(fake()->password()), // password
                                                'balance'      => 0,
                                            ]);

            //userin verify bilgilerini tutan tablo olusturuluyor
            UserVerifications::create([
                                          'userID'          => $user->userID,
                                          'phoneNumber'     => mt_rand(5000000000, 5999999999),
                                          'eMailVerify'     => $faker->randomElement([true, false]),
                                          'phoneVerify'     => $faker->randomElement([true, false]),
                                          'eMailVerifyDate' => $faker->dateTime(),
                                          'phoneVerifyDate' => $faker->dateTime(),
                                          'lastLoginDate'   => $faker->dateTime(),
                                          'registerDate'    => $faker->dateTime(),
                                      ]);

            //userin influencer bilgileri olusturuluyor
            $influencer = Influencer::create([
                                                 'userID'            => $user->userID,
                                                 'bannerPhoto'       => $influencersData[$i]['profilePhoto'] ?? 'assets/images/gamzePP.jpeg',
                                                 'agencyID'          => null,
                                                 'platformUserName'  => $faker->userName,
                                                 'fenocityPoint'     => mt_rand(1, 5),
                                                 'fenocitySaleCount' => mt_rand(100, 1000),
                                                 'bioVerifyCode'     => $faker->regexify('[A-Z]{10}[0-4]{5}'),
                                                 'infVerify'         => true,
                                                 'statsVerify'       => true,
                                                 'isInfDeleted'      => false,
                                                 'taxPayer'          => true,
                                             ]);


            //olusturulan influencerlardan idsi ile influencer category olusturuluyor
            //influencerCategoryleri influencers count kadar ekleniyor
            for ($j = 0; $j <= rand(0, 1); $j++) {
                $categoryId = rand(1, count(CategoryTypes::cases()) - 1);
                if (!InfluencerCategories::where('influencer_id', $influencer->infID)->where('category_id', $categoryId)->exists()) {
                    InfluencerCategories::factory()->create([
                                                                'influencer_id' => $influencer->infID,
                                                                'category_id'   => $categoryId,
                                                            ]);
                } else {
                    $j--;
                }
            }
            //influencerlarin hesaplarinin profil degerleri ekleniyor
            for ($j = 0; $j <= rand(0, 1); $j++) {
                $platformId = rand(1, count(PlatformTypes::cases()));
                if (!InfAccountProperties::where('infID', $influencer->infID)->where('platformID', $platformId)->exists()) {
                    InfAccountProperties::factory()->create([
                                                                'infID'      => $influencer->infID,
                                                                'platformID' => $platformId,
                                                            ]);
                } else {
                    $j--;
                }
            }

            //product yani urun olusturuluyor bu urun bir influencera aittir
            $infAccProp = InfAccountProperties::where('infID', $influencer->infID)->get();
            $proPropId  = ProductProperties::where('platform_id', $infAccProp[0]->platformID)->get();
            for ($i = 0; $i < rand(1, count($proPropId)); $i++) {
                Product::factory()->create([
                                               'influencer_id'            => $influencer->infID,
                                               'product_property_id'      => $proPropId[$i]->id,
                                               'price_for_per_minute'     => rand(1, 10000) / 10,
                                               'fenocityProductPoint'     => rand(0, 5),
                                               'fenocityProductSaleCount' => rand(1, 10000),
                                           ]);
            }
        }
        //CheckForeignKeys=1
        $this->setForeignKeyCheckOn();
    }
}
