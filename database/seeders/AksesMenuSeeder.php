<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AksesMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $multipleAksesMenu = [
            [
                "id_menu" => 1,
                "id_role" => 1,
                "act_read" => 1,
                "act_create" => 1,
                "act_update" => 1,
                "act_delete" => 1
            ],
            [
                "id_menu" => 2,
                "id_role" => 1,
                "act_read" => 1,
                "act_create" => 1,
                "act_update" => 1,
                "act_delete" => 1
            ],
            [
                "id_menu" => 3,
                "id_role" => 1,
                "act_read" => 1,
                "act_create" => 1,
                "act_update" => 1,
                "act_delete" => 1
            ],
            [
                "id_menu" => 4,
                "id_role" => 1,
                "act_read" => 1,
                "act_create" => 1,
                "act_update" => 1,
                "act_delete" => 1
            ],
            [
                "id_menu" => 5,
                "id_role" => 1,
                "act_read" => 1,
                "act_create" => 1,
                "act_update" => 1,
                "act_delete" => 1
            ],
            [
                "id_menu" => 6,
                "id_role" => 1,
                "act_read" => 1,
                "act_create" => 1,
                "act_update" => 1,
                "act_delete" => 1
            ],
            
        ];

        foreach ($multipleAksesMenu as $itemData) {
            # code...
            DB::table('akses_menu')->insert($itemData);
        }
    }
}
