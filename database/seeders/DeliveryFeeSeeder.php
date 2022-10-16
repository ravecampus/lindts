<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('standard_delivery_fee')->delete();
        DB::table('standard_delivery_fee')->insert(['id' => 1]);
        DB::table('settings')->delete();
        DB::table('settings')->insert(['id' => 1]);

        DB::table('users')->delete();
        DB::table('users')->insert([
            'id' => 1,
            'role'=>1, 
            'first_name'=>'winsdev', 
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin')
        ]);
        
    }
}
