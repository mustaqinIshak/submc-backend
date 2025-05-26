<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CetakBarcodeController extends Controller
{
    public function index () {
        try {
            //code...
            $results = [];
            $products = DB::table('produk')
            ->whereDate('created_at', Carbon::today()) // Hanya untuk tanggal hari ini
            ->get();

            foreach ($products as $productData) {
                $sizes = DB::table('size')->where('produkId', $productData->id)->get();
                foreach($sizes as $size) {
                    $result = [
                        "barcode" => $productData->barcode,
                        "name" => $productData->name,
                        "harga" => $productData->harga,
                        "size" => $size->name,
                        "jumlah_stok" => $size->jumlah
                    ];
                    array_push($results,$result);
                }
            }
           
            return response()->json([
                "status" => true,
                "data" => $results
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
    public function searchBarcodes (Request $request) {
        $this->validate($request, [
            "keyword" => "required",
        ]);
        try {
            //code...
            $persen = "%";
            $keyword = $request->keyword;;
            $results = [];
            $products = DB::table('produk')
            ->leftJoin('size', 'produk.id', '=', 'size.produkId')
            ->where('produk.name', 'like', "%{$keyword}%")
            ->orWhere('size.barcode', 'like', $keyword . $persen)
            ->select('produk.id','size.barcode','produk.name', 'size.name as size','produk.harga', 'size.jumlah')
            ->get();
            // foreach ($products as $productData) {
            //     $sizes = DB::table('size')->where('produkId', $productData->id)->get();
            //     foreach($sizes as $size) {
            //         $result = [
            //             "barcode" => $productData->barcode,
            //             "name" => $productData->name,
            //             "harga" => $productData->harga,
            //             "size" => $size->name,
            //             "jumlah_stok" => $size->jumlah
            //         ];
            //         array_push($results,$result);
            //     }
            // }
    
            return response()->json($products);
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
