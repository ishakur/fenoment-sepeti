<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Influencer;
use App\Models\User;
use App\Models\Navbar;
use App\Models\Corpadvertiser;


use Database\Seeders\AgencySeeder;
use Database\Seeders\InfluencerSeeder;
use Tests\TestCase;
use  Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function testAgenciesSeeder()
    {
        Agency::factory(5)->create();
        $this->assertDatabaseCount('agencies', 5);
    }

    public function testCategorySeeder()
    {
        Category::factory(5)->create();
        $this->assertDatabaseCount('categories', 5);
    }

    public function testCorparativeAdvertiserSeeder()
    {
        CorpAdvertiser::factory(5)->create();
        $this->assertDatabaseCount('corporate_advertisers', 5);
    }

    public function testInfluencerSeeder()
    {
        $influencerSeeder = new InfluencerSeeder();
        $influencerSeeder->run();
        $this->assertDatabaseCount('influencers', 10);
    }

    public function testNavbarSeeder()
    {
        Navbar::factory(5)->create();
        $this->assertDatabaseCount('navbar', 5);
    }

    public function testOrderSeeder()
    {
        $this->seed(AgencySeeder::class);
        $this->assertDatabaseCount('agencies', 5);
    }

    public function testUserSeeder()
    {
        User::factory(5)->create();
        $this->assertDatabaseCount('users', 5);
    }


}
