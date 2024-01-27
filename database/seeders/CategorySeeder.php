<?php

namespace Database\Seeders;

use App\Enum\CategoryTypes;
use App\Models\Category;
use App\Models\Influencer;
use App\Models\InfluencerCategories;
use App\Models\Product;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Category::truncate();
        for ($i = 0; $i < count(CategoryTypes::cases()); $i++) {
            Category::factory()->create([
                                            'category_name' => CategoryTypes::cases()[$i],
                                            'slug'          => Str::slug(CategoryTypes::cases()[$i]),
                                        ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
