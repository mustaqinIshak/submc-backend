<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('profile_company')->insert([
            "name" => "CMM Apparel",
            "alamat" => "Ruko Sinpasa blok C No 12, Sumarecon Bekasi",
            "nomor_hp" => "+62 821 9459 3969",
            "instagram" => "https://instagram.com/cmmapparel_?igshid=OGQ5ZDc2ODk2ZA==",
            "twitter" => "",
            "facebook" => "",
            "youtube" => ""
        ]);
    }
}
