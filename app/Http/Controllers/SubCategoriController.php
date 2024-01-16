<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriController extends Controller
{
    //
    public function index(Request $request) {
        $this->validate($request, [
           "id" => 'required' 
        ]);
        try {
            //code...
            $getSubCategori = DB::table('sub_categori')
            ->where("id_categori", "=", $request->id)
            ->get();
            return response()->json([
                "status" => true,
                "data" => $getSubCategori
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

    public function getAll(Request $request) {
        $this->validate($request, [
            "limit" => "required"
        ]);
        try {
            //code...
            if ($request->search) {
                # code...
                $persen = "%";
                $key = $request->search;
                $getListSubCategori = DB::table('sub_categori')
                ->leftJoin("categori", "sub_categori.id_categori", "=", "categori.id")
                ->select("sub_categori.id","sub_categori.name", "categori.name as kategori")
                ->where("sub_categori.name", "like", $key . $persen)
                ->paginate($request->limit);
            } else {
                $getListSubCategori = DB::table('sub_categori')
                ->leftJoin("categori", "sub_categori.id_categori", "=", "categori.id")
                ->select("sub_categori.id","sub_categori.name", "categori.name as kategori")
                ->paginate($request->limit);
            }
            return response()->json([
                "status" => true,
                "data" => $getListSubCategori
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

    public function getSelected(Request $request) {
        $this->validate($request, [
            "id" => 'required' 
         ]);
        try {
            //code...
            $getSelectedSubCategori = DB::table('sub_categori')
            ->leftJoin("categori", "sub_categori.id_categori", "=", "categori.id")
            ->select("sub_categori.id","sub_categori.name", "sub_categori.id_categori" ,"categori.name as kategori")
            ->where("sub_categori.id", "=", $request->id)
            ->first();

            return response()->json([
                "status" => true,
                "data" => $getSelectedSubCategori
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
            "idCategori" => "required",
            "name" => "required|string|unique:sub_categori,name",
        ]);
        try {
            //code...
            $searchCategori = DB::table('categori')
            ->where('id', '=', $request->idCategori)
            ->first()
            ;

            if($searchCategori) {
                $createdAt = Carbon::now();
                DB::table('sub_categori')
                ->insert([
                    "id_categori" => $request->idCategori,
                    "name" => $request->name,
                    "created_at" => $createdAt,
                    "updated_at" => $createdAt
                ]);
                return response()->json([
                    "status" => true,
                    "message" => "insert sub categori success"
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "id categori not found"
                ]);
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

    public function update(Request $request) {
        $this->validate($request, [
            "id" => "required",
            "idCategori" => "required",
            "name" => "required|string",
        ]);
        try {
            //code...
            $searchCategori = DB::table('categori')
            ->where('id', '=', $request->idCategori)
            ->first()
            ;
            if($searchCategori) {
                $findName = DB::table('sub_categori')
                ->where("name", "=", $request->name)
                ->first()
                ;
                if($findName && ($findName->id != $request->id)) {
                    return response()->json([
                        "status" => false,
                        "message" => "The name has already been taken."
                    ]);
                } else {
                    $updateAt = Carbon::now();
                    DB::table('sub_categori')
                    ->where('id', '=', $request->id)
                    ->update([
                        "id_categori" => $request->idCategori,
                        "name" => $request->name,
                        "updated_at" => $updateAt
                    ]);
                    return response()->json([
                        "status" => true,
                        "message" => "update sub categori success"
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "id categori not found"
                ]);
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

    public function delete(Request $request) {
        $this->validate($request, [
            "id" => 'required' 
         ]);
        try {
            //code...
            DB::table('sub_categori')
            ->where("id", "=", $request->id)
            ->delete();

            DB::table('produk')
            ->where("id_sub_categori", "=", $request->id)
            ->delete();

            return response()->json([
                "status" => true,
                "message" => "delete sub categori success"
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
}
