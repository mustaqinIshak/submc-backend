<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoriSeeder extends Seeder
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
        $multipleCategori = [
            [
                "name" => "T-Shirt",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                "name" => "Shirt",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                "name" => "Jacket",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                "name" => "Pants",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                "name" => "Accessories",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                "name" => "Headwear",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                "name" => "Footwear",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            [
                "name" => "Collaboration",
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ],
            
        ];

        foreach ($multipleCategori as $itemData) {
            # code...
            DB::table('Categori')->insert($itemData);
        };
    }
}
