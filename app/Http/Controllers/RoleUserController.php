<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\RoleUser;
use Illuminate\Auth\RequestGuard;

class RoleUserController extends Controller
{
    //
    public function getAll() {
        try {
            //code...
            $getRoleUsers = DB::table('roles_user')->get();

            return response()->json([
                "status" => true,
                "data" => $getRoleUsers
            ]);
        } catch (\Exception $e) {
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function getRoleUser(Request $request) {
        $this->validate($request, [
            "limit" => "required"
        ]);
        try {
            //code...
            // $getRoleUsers = DB::select('select a.id, a.name, GROUP_CONCAT(c.name) as list_menu FROM roles_user as a
            // INNER JOIN akses_menu as b ON a.id = b.id_role
            // INNER JOIN menu as c ON b.id_menu = c.id
            // GROUP BY(a.id)
            // ');
            if($request->search) {
                $getRoleUsers = DB::table('roles_user')
                ->join("akses_menu", "roles_user.id", '=', "akses_menu.id_role")
                ->join("menu", "akses_menu.id_menu", '=', "menu.id")
                ->select('roles_user.id','roles_user.name', DB::raw("GROUP_CONCAT(menu.name) as `menu`"))
                ->groupBy('roles_user.id')
                ->where('roles_user.name', 'like', $request->search)
                ->paginate($request->limit);    
            } else {
                $getRoleUsers = DB::table('roles_user')
                ->join("akses_menu", "roles_user.id", '=', "akses_menu.id_role")
                ->join("menu", "akses_menu.id_menu", '=', "menu.id")
                ->select('roles_user.id','roles_user.name', DB::raw("GROUP_CONCAT(menu.name) as `menu`"))
                ->groupBy('roles_user.id')
                ->paginate($request->limit);
            }

            return response()->json([
                "status" => true,
                "data" => $getRoleUsers
            ]);
        } catch (\Exception $e) {
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
        }
    }

    public function getSelected(Request $request) {
        $this->validate($request, [
            "id" => 'required'
        ]);
        try {
            //code...
            $getRoleUsers = DB::table('roles_user')->where('id', '=', $request->id)->first();
            $getAksesMenu = DB::table('akses_menu')->where('id_role','=',$request->id)->get();

            return response()->json([
                "status" => true,
                "data" => [
                  "id" => $getRoleUsers->id,
                  "name" => $getRoleUsers->name,
                  "akses_menu" => $getAksesMenu,
                ]
            ]);
        } catch (\Exception $e) {
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function create(Request $request) {
        $this->validate($request, [
            "name" => "required|string|unique:roles_user,name",
            "aksesMenu" => "required"
        ]);
        try {
            //code...

            $createRole = DB::table("roles_user")->insert([
                "name" => $request->name
            ]);
            $role = DB::table('roles_user')->orderBy('id', 'desc')->first();
          
            foreach($request->aksesMenu as $itemData) {
                $menu = DB::table('menu')->where('name', '=', $itemData['name'])->first();
                $createAksesMenu = DB::table('akses_menu')->insert([
                    "id_menu" => $menu->id,
                    "id_role" => $role->id,
                    "act_read" => $itemData['actRead'] ? 1 : 0,
                    "act_create" => $itemData['actCreate'] ? 1 : 0,
                    "act_update" => $itemData['actUpdate'] ? 1 : 0,
                    "act_delete" => $itemData['actDelete'] ? 1 : 0,
                ]);
            }

            return response()->json([
                "status" => true,
                // "data" => $item,
                "message" => "create role user success"
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
    
    public function edit(Request $request) {
        $this->validate($request, [
            "id" => "required",
            "name" => "required"
        ]);
        try {

            $updateRole = DB::table('roles_user')
            ->where('id', $request->id)
            ->update([
                "name" => $request->name,
            ]);

            foreach($request->aksesMenu as $itemData) {
                $menu = DB::table('menu')->where('name', '=', $itemData['name'])->first();
                if(!$itemData['actRead'] && $menu->id != 1) {
                    $deleteAksesMenu =  DB::table('akses_menu')
                    ->where([
                        ['id_menu', '=', $menu->id],
                        ['id_role', '=', $request->id],
                    ])
                    ->delete();
                } else {
                    $createAksesMenu = DB::table('akses_menu')
                    ->updateOrInsert(
                        ['id_menu' => $menu->id,
                        'id_role' => $request->id],
                        ["act_read" => $itemData['actRead'] ? 1 : 0,
                        "act_create" => $itemData['actCreate'] ? 1 : 0,
                        "act_update" => $itemData['actUpdate'] ? 1 : 0,
                        "act_delete" => $itemData['actDelete'] ? 1 : 0]
                    );
                };
            }
            return response()->json([
                "status" => true,
                "message" => "edit role user success"
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
