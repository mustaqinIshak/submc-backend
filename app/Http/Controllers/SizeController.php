<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SizeController extends Controller
{
    //
    public function index(Request $request) {
        $this->validate($request, [
            "id" => "required"
        ]);

        $getSizes = DB::table("size")->where('produkId', '=', $request->id)->get();
        return response()->json([
            "status" => true,
            "data" => $getSizes,
        ]);
    }

    public function update (Request $request) {
        $this->validate($request, [
            "id"=> "required",
            "name" => "required",
            "jumlah" => "required",
        ]);
        $updateAt = Carbon::now();
        try {
            //code...
            DB::table("size") ->where('id', '=', $request->id)
            ->update([
                "name" => $request->name,
                "jumlah" => $request->jumlah,
                "updated_at" => $updateAt,
            ]);
            return response()->json([
                "status" => true,
                "message" => "edit size success"
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function create(Request $request) {
        $this->validate($request, [
            "idProduk" => "required",
            "name" => "required",
            "jumlah" => "required",
        ]);
        try {
            //code...
            $insertSize =   Size::create([
                "produkId" => $request->idProduk,
                "name" => $request->name,
                "jumlah" => $request->jumlah,
            ]);

            if($insertSize) {
                return response()->json([
                    "status" => true,
                    "message" => "add size success"
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "add size fail"
                ],400);
                die;
            }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function delete (Request $request) {
        $this->validate($request, [
            "id"=> "required",
            "idProduk" => "required",
        ]);
        try {
            //code...
            DB::table('size')
            ->where("id", "=", $request->id)
            ->delete();

            return response()->json([
                "status" => true,
                "message" => "delete size success"
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
