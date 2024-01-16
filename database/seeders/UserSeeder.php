<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $createMultipleUsers = [
            [
                'name'=>'mustaqin ishak',
                "username"=>'mustaqinishak', 
                "password" => Hash::make("takin230793"),
                "id_role" => 1,
            ],
            [
                'name'=>'bimo',
                "username"=>'admincmmapparel', 
                "password" => Hash::make("cmmapparel2022"),
                "id_role" => 1,
            ]
            
        ];

        foreach ($createMultipleUsers as $itemData) {
            # code...
            DB::table('users')->insert($itemData);
        }
    }
}
