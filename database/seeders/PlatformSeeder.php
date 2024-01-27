<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Influencer;
use App\Models\Platform;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlatformSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setForeignKeyCheckOff();
        Platform::truncate();

        $platforms = [
            'Instagram',
            'Tiktok',
            'Youtube',
            'Twitter',
            'Facebook'
        ];


        for ($i = 0; $i < count($platforms); $i++) {

            Platform::create([
                'platform_name' => $platforms[$i],
                'slug'          => Str::slug($platforms[$i]),
                'platform_rank' => $i,
                'platform_icon' => 'icon',
            ]);
        }

        $this->setForeignKeyCheckOn();
    }
}
