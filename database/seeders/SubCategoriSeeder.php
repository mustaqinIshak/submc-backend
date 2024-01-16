<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubCategoriSeeder extends Seeder
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
        $multipleSubCategori = [
            [
                "id_categori" => 1,
                "name" => "Short Sleve",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 1,
                "name" => "Long Sleve",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 2,
                "name" => "Short Shirt",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 2,
                "name" => "Long Shirt",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 3,
                "name" => "Pullover",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 3,
                "name" => "Hoodie",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 3,
                "name" => "Crewneck",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 3,
                "name" => "Cardigan",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 3,
                "name" => "Coach Jacket",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 4,
                "name" => "Short Pants",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 4,
                "name" => "Long Pants",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 5,
                "name" => "keychain",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 5,
                "name" => "Wallet",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 5,
                "name" => "Belt",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 5,
                "name" => "Stickers",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 5,
                "name" => "Scarf",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 5,
                "name" => "Eyewear",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 6,
                "name" => "Hats",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 6,
                "name" => "Benies",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 7,
                "name" => "Shoes",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 7,
                "name" => "Socks",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 7,
                "name" => "Sandals",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 8,
                "name" => "T-Shirt",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 8,
                "name" => "Jacket",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 8,
                "name" => "Hats",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
            [
                "id_categori" => 8,
                "name" => "Accessories",
                "created_at" => $createdAt,
                "updated_at" => $createdAt
            ],
        ];

        foreach ($multipleSubCategori as $dataItem) {
            # code...
            DB::table("sub_categori")->insert($dataItem);
        }
    }
}
