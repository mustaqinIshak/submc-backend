<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $createdAt = Carbon::now();
        $createBrand = [
            [
                'name'=>'crasher',
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                'name'=>'crasher music merchandise',
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                'name'=>'cmm apparel',
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ]
            
        ];
        foreach ($createBrand as $itemData) {
            # code...
            DB::table('brand')->insert($itemData);
        }
    }
}
