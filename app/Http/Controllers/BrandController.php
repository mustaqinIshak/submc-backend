<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    //
    public function index () {
        try {
            //code...
            $getBrand = DB::table('brand')->get();
           
            return response()->json([
                "status" => true,
                "data" => $getBrand
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
    public function getAll (Request $request) {
        $this->validate($request, [
            "limit" => "required",
        ]);
        try {
            //code...
            $getBrand = DB::table('brand')
            ->leftJoin("produk","brand.id",'=','produk.id_brand')
            ->select('brand.*', DB::raw("COUNT(produk.id) as 'jumlah_artikel'"))
            ->groupBy('brand.id')
            ->orderBy('brand.id', 'desc')
            ->paginate($request->limit);
           
            return response()->json([
                "status" => true,
                "data" => $getBrand
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

    public function getSelected (Request $request) {
        $this->validate($request, [
            "id" => "required"
        ]);
        try {
            //code...
            $getCategori = DB::table('brand')
            ->where('id', '=', $request->id)
            ->first();

            return response()->json([
                "status" => true,
                "data" => $getCategori
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
    public function create (Request $request) {
        $this->validate($request,[
            "name" => "required|string|unique:categori,name",
        ]);
        try {
            //code...
            $createdAt = Carbon::now();
            $createKategori = DB::table('brand')
            ->insert([
                "name" => $request->name,
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ]);
            return response()->json([
                "status" => true,
                "message" => "create brand success"
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

    public function update (Request $request) {
        $this->validate($request,[
            "id" => "required",
            "name" => "required"
        ]);
        try {
            //code...
            $updateAt = Carbon::now();
            $updateKategori = DB::table("brand")
            ->where('id', '=', $request->id)
            ->update([
                "name" => $request->name,
                "updated_at" => $updateAt,
            ]);
            return response()->json([
                "status" => true,
                "message" => "edit brand success"
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
