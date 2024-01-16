<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriController extends Controller
{
    //
    public function index () {
        try {
            //code...
            $getCategori = DB::table('categori')->get();
           
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
    public function getAll (Request $request) {
        $this->validate($request, [
            "limit" => "required"
        ]);
        try {
            //code...
            if($request->search) {
                $persen = "%";
                $key = $request->search;
                $getCategori = DB::table('categori')
                ->leftJoin("sub_categori", "categori.id", "=", "sub_categori.id_categori")
                ->select('categori.id','categori.name', DB::raw("GROUP_CONCAT(sub_categori.name) as `subCategori`"))
                ->groupBy('categori.id')
                ->groupBy('categori.name')
                ->where('categori.name', 'like', $key . $persen)
                ->paginate($request->limit);
            } else {
                $getCategori = DB::table('categori')
                ->leftJoin("sub_categori", "categori.id", "=", "sub_categori.id_categori")
                ->select('categori.id','categori.name', DB::raw("GROUP_CONCAT(sub_categori.name) as `subCategori`"))
                ->groupBy('categori.name')
                ->groupBy('categori.id')
                ->paginate($request->limit);
            }
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

    public function getSelected (Request $request) {
        $this->validate($request, [
            "id" => "required"
        ]);
        try {
            //code...
            $getCategori = DB::table('categori')
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
            $createKategori = DB::table('categori')
            ->insert([
                "name" => $request->name,
                "created_at" => $createdAt,
                "updated_at" => $createdAt,
            ]);
            return response()->json([
                "status" => true,
                "message" => "create categori success"
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
            $updateKategori = DB::table("categori")
            ->where('id', '=', $request->id)
            ->update([
                "name" => $request->name,
                "updated_at" => $updateAt,
            ]);
            return response()->json([
                "status" => true,
                "message" => "edit categori success"
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

    public function delete (Request $request) {
        $this->validate($request, [
            "id" => "required"
        ]);
        try {
            //code...
            $deleteKategori = DB::table('categori')
            ->where("id", "=", $request->id)
            ->delete();

            $deleteSubKategori = DB::table('sub_categori')
            ->where("id_categori", "=", $request->id)
            ->delete();
            ;

            $deleteProduk = DB::table('produk')
            ->where("id_categori", "=", $request->id)
            ->delete();

            return response()->json([
                "status" => true,
                "message" => "delete categori success"
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
