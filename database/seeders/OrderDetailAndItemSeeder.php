<?php

namespace Database\Seeders;

use App\Models\OrderDetails;
use App\Models\OrderItems;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailAndItemSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setForeignKeyCheckOff();
        OrderDetails::truncate();
        OrderDetails::factory()->count(10)->create();
        OrderItems::truncate();
        OrderItems::factory(100)->create();
        $this->setForeignKeyCheckOn();
    }
}
