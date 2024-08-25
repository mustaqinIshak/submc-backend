<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AksesMenuController extends Controller
{
    //
    public function getAllAksesMenu( Request $request) {
        try {
            //code...
            $me = auth()->user();

            $aksesMenu = DB::table('akses_menu')
                ->join('menu', 'akses_menu.id_menu', '=', 'menu.id')
                ->where('id_role', '=', $me->id_role)
                ->select('menu.*')
                ->get();

            return response()->json([
                "status" => true,
                "data" => $aksesMenu,
            ]);  

        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;

        }
    }

    public function getSelectedAksesMenu ( Request $request ) {
        try {
            //code...
            $this->validate($request, [
                "id_menu" => "required"
            ]);
            $me = auth()->user();

            $aksesMenu = DB::table('akses_menu')
                ->where([
                    ['id_menu', '=', $request->id_menu],
                    ['id_role', '=', $me->id_role],
                ])->first();

            return response()->json([
                "status" => true,
                "data" => [
                    "id" => (int)$aksesMenu->id,
                    "id_menu"=> (int)$aksesMenu->id_menu,
                    "id_role"=> (int)$aksesMenu->id_role,
                    "act_create"=> (int)$aksesMenu->act_create,
                    "act_read"=> (int)$aksesMenu->act_read,
                    "act_update"=> (int)$aksesMenu->act_update,
                    "act_delete"=> (int)$aksesMenu->act_delete
                ],
            ]);  
        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function createAksesMenu ( Request $request) {
        try {
            //code...
            $this->validate($request, [
                "id_menu" => "required",
                "id_role" => "required",
                "act_create" => "required",
                "act_read" => "required",
                "act_update" => "required",
                "act_delete" => "required",
            ]);

            $findData = DB::table('akses_menu')
            ->where([ 
                ['id_menu', '=', $request->id_menu],
                ['id_role', '=', $request->id_role],
            ])
            ->first();

            if($findData) {
                $aksesMenu = DB::table('akses_menu')
                ->where([ 
                    ['id_menu', '=', $request->id_menu],
                    ['id_role', '=', $request->id_role],
                ])
                ->update([
                    "act_create" => $request->act_create,
                    "act_read" => $request->act_read,
                    "act_update" => $request->act_update,
                    "act_delete" => $request->act_delete,
                ]);
            } else {
                $aksesMenu = DB::table('akses_menu')->insert([
                    "id_menu" => $request->id_menu,
                    "id_role" => $request->id_role,
                    "act_create" => $request->act_create,
                    "act_read" => $request->act_read,
                    "act_update" => $request->act_update,
                    "act_delete" => $request->act_delete,
                ]);
            }
         
            return response()->json([
                "status" => true,
                "message" => "add akses menu success"
            ]);
            

        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }
}
