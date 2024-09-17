<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CrasherController extends Controller
{
    //
    function getNewItem() {
        try {
            //code...
            $getProduks = DB::table('produk')
            ->where('produk.status', '=', 1)
            ->select('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            ;
            foreach ($getProduks as $item) { 
                # code...
                $getGambarProduk = DB::table('gambar_produk')
                ->where("produkId", "=", $item->id)
                ->get()
                ;
    
                $item->gambar1 = $getGambarProduk[0];
                $item->gambar2 = $getGambarProduk[1] ? $getGambarProduk[1] : $getGambarProduk[0];
    
            }
           
            return response()->json([
                "status" => true,
                "data" => $getProduks,
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

    function getProfileCompany() {
        try {
            //code...
            $getContact = DB::table('profile_company')
            ->select('name', 'alamat', 'nomor_hp', 'instagram', 'facebook', 'youtube')
            ->first();
           
            return response()->json([
                "status" => true,
                "data" => $getContact,
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

    function getAboutUs() {
        try {
            //code...
            $getAboutUs = DB::table('profile_company')
            ->select('about_us')
            ->first();
           
            return response()->json([
                "status" => true,
                "data" => $getAboutUs,
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

    function getBannerHome() {
        try {
            //code...
            $getBanners = DB::table('banner_home')
            ->get();
           
            return response()->json([
                "status" => true,
                "data" => $getBanners,
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

    function getProduk(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "id" => "required",
            ]);
            $result = DB::table('produk')
            ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
            ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
            ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
            ->where("produk.id", "=", $request->id)
            ->select('produk.*', 'categori.name as categoriName', 'sub_categori.name as subKategoriName', 'brand.name as brandName')
            ->first();
            
            if($result) {
                $getGambarProduk = DB::table('gambar_produk')
                ->where("produkId", "=", $request->id)
                ->get()
                ;
    
                $getSize = DB::table('size')
                ->where('produkId', '=', $request->id)
                ->get();
    
                $result->gambar = $getGambarProduk;
                $result->sizes = $getSize;
    
                return response()->json([
                    "status" => true,
                    "data" => $result,
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "data tidak ditemukan",
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
    
    function getByCategorie(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "idCategorie" => "required",
            ]);

            $idCategorie = $request->idCategorie;
            if($idCategorie === 0) {
                $result = DB::table('produk')
                ->where('produk.status', '=', 1)
                ->select('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
                ->orderBy('created_at', 'desc')
                ->groupBy('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
                ->orderBy('produk.id', 'desc')
                ->paginate(10);
            }
            else if($request->idSubCategorie) {
                $result = DB::table('produk')
                ->where('produk.status', '=', 1)
                ->where('produk.id_sub_categori', '=', $request->idSubCategorie)
                ->select('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
                ->orderBy('created_at', 'desc')
                ->groupBy('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
                ->orderBy('produk.id', 'desc')
                ->paginate(10);
            } else {
                $result = DB::table('produk')
                ->where('produk.status', '=', 1)
                ->where('produk.id_categori', '=', $idCategorie)
                ->select('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
                ->orderBy('created_at', 'desc')
                ->groupBy('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
                ->orderBy('produk.id', 'desc')
                ->paginate(10);
            }
            foreach ($result as $item) { 
                # code...
                $getGambarProduk = DB::table('gambar_produk')
                ->where("produkId", "=", $item->id)
                ->get()
                ;
    
                $item->gambar1 = $getGambarProduk[0];
                $item->gambar2 = $getGambarProduk[1] ? $getGambarProduk[1] : $getGambarProduk[0];
    
            }

            return response()->json([
                "status" => true,
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

    function getCategorie() {
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

    function getSubCategorie(Request $request) {
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

    function getProdukByCmm() {
        try {
            //code...
            $getProduks = DB::table('produk')
            ->leftJoin('brand','produk.id_brand', '=', 'brand.id')
            ->select('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
            ->where('produk.status', '=', 1)
            ->where('brand.name','like','cmm apparel' . "%")
            ->orderBy('produk.created_at', 'desc')
            ->paginate(10);
            
            foreach ($getProduks as $item) { 
                # code...
                $getGambarProduk = DB::table('gambar_produk')
                ->where("produkId", "=", $item->id)
                ->get()
                ;
    
                $item->gambar1 = $getGambarProduk[0];
                $item->gambar2 = $getGambarProduk[1] ? $getGambarProduk[1] : $getGambarProduk[0];
    
            }
           
            return response()->json([
                "status" => true,
                "data" => $getProduks,
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

    function getProdukByCrasherMusicMenchandise() {
        try {
        $getProduks = DB::table('produk')
            ->leftJoin('brand','produk.id_brand', '=', 'brand.id')
            ->select('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
            ->where('produk.status', '=', 1)
            ->where('brand.name','like','crasher music merchandise' . "%")
            ->orderBy('produk.created_at', 'desc')
            ->paginate(10);
        
            foreach ($getProduks as $item) { 
                # code...
                $getGambarProduk = DB::table('gambar_produk')
                ->where("produkId", "=", $item->id)
                ->get()
                ;
    
                $item->gambar1 = $getGambarProduk[0];
                $item->gambar2 = $getGambarProduk[1] ? $getGambarProduk[1] : $getGambarProduk[0];
    
            }
           
            return response()->json([
                "status" => true,
                "data" => $getProduks,
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

    function getBrands() {
        try {
            //code...
            $getBrands = DB::table('brand')
            ->select('id','name')
            ->get();
            return response()->json([
                "status" => true,
                "data" => $getBrands,
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

    function getProdukByBrand(Request $request) {
        $this->validate($request, [
            "id" => "required"
        ]);
        $idBrand = $request->id;
        try {
        $getProduks = DB::table('produk')
            ->leftJoin('brand','produk.id_brand', '=', 'brand.id')
            ->select('produk.id', 'produk.name', 'produk.harga', 'produk.sale', 'produk.jumlah_sale', 'produk.start_sale', 'produk.end_sale')
            ->where('produk.status', '=', 1)
            ->where('produk.id_brand','=',$idBrand)
            ->orderBy('produk.created_at', 'desc')
            ->paginate(10);
        
            foreach ($getProduks as $item) { 
                # code...
                $getGambarProduk = DB::table('gambar_produk')
                ->where("produkId", "=", $item->id)
                ->get()
                ;
    
                $item->gambar1 = $getGambarProduk[0];
                $item->gambar2 = $getGambarProduk[1] ? $getGambarProduk[1] : $getGambarProduk[0];
    
            }
           
            return response()->json([
                "status" => true,
                "data" => $getProduks,
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
