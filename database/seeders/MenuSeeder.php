<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $multipleMenu = [
            [
                "name" => "Dashboard",
                "link" => "/dashboard",
                "jenis" => "view",
                "element" => "Dashboard"
            ],
            [
                "name" => "Produk",
                "link" => "/dashboard/produk",
                "jenis" => "view",
                "element" => "Produk"
            ],
            [
                "name" => "Kategori",
                "link" => "/dashboard/kategori",
                "jenis" => "view",
                "element" => "Kategori"
            ],
            [
                "name" => "Profil Perusahaan",
                "link" => "/dashboard/profilCompany",
                "jenis" => "view",
                "element" => "Profil Perusahaan"
            ],
            [
                "name" => "User",
                "link" => "/dashboard/user",
                "jenis" => "view",
                "element" => "User"
            ],
            [
                "name" => "Banner Home",
                "link" => "/dashboard/bannerHome",
                "jenis" => "view",
                "element" => "Banner Home"
            ],
        ];

        foreach ($multipleMenu as $itemData) {
            # code...
            DB::table('menu')->insert($itemData);
        }
    }
}
