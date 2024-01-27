<?php

namespace Database\Seeders;

use App\Models\Corpadvertiser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorpAdvertiserSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Corpadvertiser::factory(5)->create();
    }
}
