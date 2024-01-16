<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class MenuController extends Controller
{
    //
    public function postMenu(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "name" => "required|string",
                "link" => "required",
                "jenis" => "required",
            ]);
            $menu = DB::table('menu')->insert([
                'name' => $request->name,
                'link' => $request->link,
                'jenis' => $request->jenis,
                'element' => $request->element,
            ]);

         
            return response()->json([
                "status" => true,
                "message" => "add menu success"
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

    public function getMenu(Request $request) {
        try {
            //code...
            $menu = DB::table("menu")->get();
            // error_log($data);
            return response()->json([
                "status" => true,
                "data" => $menu,
            ]);
            // if($menu) {
            // } else {
            //     return response(400)->json([
            //         "status" => false,
            //         "message" => "failed get menu"
            //     ]);
            // }
        } catch (\Exception $e) {
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function updateMenu(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "id" => "required",
                "name" => "required|string",
                "link" => "required",
                "jenis" => "required",
            ]);
            $menu = DB::table("menu")->where('id', $request->id)->update([
                'name' => $request->name,
                'link' => $request->link,
                'jenis' => $request->jenis,
                'element' => $request->element,
            ]);

            
            return response()->json([
                "status" => true,
                "message" => "update menu success"
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

    public function deleteMenu(Request $request) {
        $this->validate($request, [
            "id" => "required",
        ]);

        try {
            //code...
        } catch (\Exception $e) {
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }
}
