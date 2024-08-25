<?php

namespace App\Http\Controllers;

use App\Models\GambarProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GambarProdukController extends Controller
{
    //
    public function index(Request $request) {
        $this->validate($request, [
            "id" => "required"
        ]);

        try {  
            $getGambarProduk = DB::table("gambar_produk")
            ->where("produkId", "=", $request->id)
            ->get()
            ;

            return response()->json([
                "status" => true,
                "data" => $getGambarProduk
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
            "gambar" => "required"
        ]);
        try {
            $images = $request->file('gambar');
            $result = array();
            foreach ($images as $image) {
                // $path = $image->store('uploads'); // Store images in the "uploads" directory.
                $produkId = $request->idProduk;
                $clearedString = str_replace(' ', '', $image->getClientOriginalName());
                $imageName = time() . '.' . $clearedString ;
                $image->move('produkImg', $imageName);
                $pathGambar = url('produkImg'.'/'.$imageName);
                $insertGambar = GambarProduk::create([
                    "produkId" => $produkId,
                    "name" => $imageName,
                    "path" => $pathGambar,
                ]);
                array_push($result, $insertGambar);
            }

            return response()->json([
                "status" => true,
                "message" => "insert gambar success",
                "data" => $result,
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
    public function delete(Request $request) {
        $this->validate($request, [
            "id"=> 'required',
            "idProduk" => "required"
        ]);
        try {
            //code...
            $getGambar = DB::table('gambar_produk')->where("id", '=', $request->id)
            ->first();

            if($getGambar) {
                // $parsedUrl = parse_url($getGambar->gambar);
                // $domain = $parsedUrl['host'];
                // $filePath = public_path($parsedUrl['path']);
                // error_log($filePath);
                $pathNameGambar = 'produkImg'.'/'.$getGambar->name;
                if(File::exists($pathNameGambar)) {
                    File::delete($pathNameGambar);
                    DB::table('gambar_produk')
                    ->where('id', '=', $request->id)
                    ->delete()
                    ;
                    return response()->json([
                        "status" => true,
                        "message" => "Delete Gambar Produk Success",
                    ]);
                } else {
                    return response()->json([
                        "status" => false,
                        "message" => "Gambar Produk yang anda ingin hapus tidak ditemukan",
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Id Gambar Produk tidak di temukan",
                ], 400);
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
}
