<?php

namespace Database\Seeders;

use App\Models\Navbar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavbarSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Navbar::factory(5)->create();
    }
}
