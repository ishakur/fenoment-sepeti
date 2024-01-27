<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Influencer;
use App\Models\InfluencerCategories;
use App\Models\OrderDetails;
use App\Models\User;
use Database\Factories\InfluencerFactory;
use Faker\Generator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //tum Adminler Ekleniyor. ilk olarak admin ekleniyor ardindan truncate islemleri burada yapiliyor
        $this->call(AdminSeeder::class);

        //ilk once category seed ediliyor olusturulan categoryler influencer seedinde  kullaniliyor
        $this->call(CategorySeeder::class);

        //platformlar ekleniyor bu platformlar influencer olusturuken influencers_account_properties tablosuna ekleniyor
        $this->call(PlatformSeeder::class);

        //influencer seedi. ayni zamanda InfluencerCategoryde Basiliyor aynı zamanda ınfluencerların hesaplarının profil degerleri ekleniyor
        //urunler ekleniyor urunler ayni zamanda influencerlar oluyor
        $this->call(InfluencerSeeder::class);

        //user factory kullanilarak 5 adet user ekleniyor
//        $this->call(UserSeeder::class);

        //influencerlarin ajanslari ekleniyor
        $this->call(AgencySeeder::class);

        //kurumsal reklam verenler ekleniyor
        $this->call(CorpAdvertiserSeeder::class);

        //navbardaki kategoriler ekleniyor
        $this->call(NavbarSeeder::class);

        //sepet ve icerisine urunler ekleniyor
        $this ->call(OrderDetailAndItemSeeder::class);


    }
}
