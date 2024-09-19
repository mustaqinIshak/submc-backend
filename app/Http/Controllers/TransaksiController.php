<?php

namespace App\Http\Controllers;

use App\Models\KodeTransaksi;
use App\Models\Produk;
use App\Models\Size;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    //
    function index(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "id" => "required",
            ]);
            $getKodeTransaksi = DB::table('kode_transaksis')
            ->where("id", '=', $request->id)
            ->first();

            $getItemTransaksi = DB::table('transaksi')
            ->leftJoin('produk', 'transaksi.idProduk', '=','produk.id')
            ->leftJoin('size', 'transaksi.idSize', '=', 'size.id')
            ->where('transaksi.idKodeTransaksi', "=", $request->$getKodeTransaksi->id )
            ->select('transaksi.*','produk.name as namaProduk','produk.harga as hargaProduk','size.name as namaSize',)
            ->get();
          
            return response()->json([
                "status" => true,
                "data" => $getItemTransaksi,
            ]);

            
            return response()->json([
                "status" => true,
                "data" => $getItemTransaksi,
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

    public function getCountTransaksiShopee(Request $request) {
        
        try {
            //code...
            $getCount = DB::table('size')
            ->count('id');

            return response()->json([
                "status" => true,
                "data" => $getCount,
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

    public function getCountTransaksiWa(Request $request) {
        
        try {
            //code...
            $getCount = DB::table('size')
            ->count('id');

            return response()->json([
                "status" => true,
                "data" => $getCount,
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

    public function searchProduk(Request $request)
    {
        try {
            $keyword = $request->keyword;;
            $results = [];
            $products = DB::table('produk')->where('name', 'like', "%{$keyword}%")
                                ->orWhere('barcode', 'like', "%{$keyword}%")
                                ->get();
            foreach ($products as $productData) {
                $sizes = DB::table('size')->where('produkId', $productData->id)->get();
                foreach($sizes as $size) {
                    $result = [
                        "id" => $productData->id,
                        "barcode" => $productData->barcode,
                        "name" => $productData->name,
                        "harga" => $productData->harga,
                        "id_size"=>$size->id,
                        "size" => $size->name,
                        "diskon" => $productData->jumlah_sale ? $productData->jumlah_sale : 0,
                        "jumlah_stok" => $size->jumlah
                    ];
                    array_push($results,$result);
                }
            }
    
            return response()->json($results);
        }catch (\Exception $e) {
            //throw $th;
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
        
    }

    function store(Request $request) {
        $this->validate($request, [
            'produks' => 'required',
            'total' => 'required',
            'idMetodePembayaran' => 'required',
        ]);
        try {
            $products = $request->produks; // Array produk dengan id dan quantity
            $user = Auth::user();
            $transaction = new KodeTransaksi();
            $transaction->kode = Str::uuid(); 
            $transaction->idTax = $request->idMetodePembayaran;  
            $transaction->idUser = $user->id;  
            $transaction->amount = 0; // Awal total amount
            $transaction->status = 0;
            $transaction->save();
    
            $totalAmount = 0;
    
            foreach ($products as $productData) {
                // $product = Produk::find($productData['id']);
                // $size = Size::find($productData['id_size']);
                // if ($product->stock < $productData['quantity']) {
                //     return response()->json(['message' => 'Stok tidak mencukupi untuk produk ' . $product->name], 400);
                // }
    
                // $product->stock -= $productData['quantity'];
                // $product->save();
    
                // $detail = new Transaksi();
                // $detail->transaction_id = $transaction->id;
                // $detail->product_id = $product->id;
                // $detail->quantity = $productData['quantity'];
                // $detail->price = $product->price;
                // $detail->save();
    
                // $totalAmount += $product->price * $productData['quantity'];
                $product = DB::table('produk')->where('id','=', $productData['id'])->first();
                $size = DB::table('size')->where('id', '=', $productData['id_size'])->first();
               
                if ($size->jumlah < $productData['quantity']) {
                    return response()->json([
                        'message' => 'Stok tidak mencukupi untuk produk ' . $product->name,
                        ]
                        , 400);
                }
                $size->jumlah -= $productData['quantity'];
                
                DB::table('size')->where('id', '=', $productData['id_size'])->update([
                    "jumlah" => $size->jumlah
                ]);
                $detail = new Transaksi();
                $detail->idKodeTransaksi = $transaction->id;
                $detail->idProduk = $product->id;
                $detail->idSize = $size->id;
                $detail->hargaSatuan = $product->harga;
                $detail->jumlahBarang = $productData['quantity']; 
                $detail->diskon = $productData['diskon'] ? $productData['diskon'] : 0;
                $detail->diskon_amount = $productData['diskon_amount'] ? $productData['diskon_amount'] : 0;
                $detail->note = $productData['note'] ? $productData['note'] : null; 
                $detail->total = $productData['total'];
                $detail->save();
                $totalAmount += $productData['total'];
            }
            if($request->total === $totalAmount) {
                $transaction->amount = $totalAmount;
                $transaction->status = 1;
                $transaction->save();

                return response()->json([
                    'status' => true,
                    'message' => "Transaksi Berhasil"
                ], 201);

            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Something Wrong"
                ],400);
            }
            // return response()->json([
            //     'status' => true,
            // ], 201);
        }   catch (\Exception $e) {
            //throw $th;
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    function create(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "idKodeTransaksi" => "required",
                "idProduk" => "required",
                "idSize" => "required",
                "hargaSatuan" => "required",
                "jumlahBarang" => "required",
                "total" => "required",
            ]);

            Transaksi::create([
                    "idKodeTransaksi"=> $request->idKodeTransaksi, 
                    "idProduk" => $request->idProduk, 
                    "idSize"=> $request->idSize, 
                    "hargaSatuan"=> $request->hargaSatuan, 
                    "jumlahBarang"=> $request->jumlahBarang, 
                    "diskon"=> $request->diskon ? $request->diskon : 0, 
                    "diskon_amount"=> $request->diskonAmount ? $request->diskonAmount : 0,
                    "total"=> $request->total, 
                    "note"=> $request->note && $request->note,
            ]);
  

            return response()->json([
                "status" => true,
                "message" => "add item transaksi success",
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

    function update(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "id" => "required",
                "idKodeTransaksi" => "required",
                "idProduk" => "required",
                "idSize" => "required",
                "hargaSatuan" => "required",
                "jumlahBarang" => "required",
                "total" => "required",
            ]);

           

               
            $findSize = DB::table('size')->where('id','=', $request->idSize)->first();
            $jumlahSize = $findSize->jumlah;
            $jumlahBarang = $request->jumlahBarang;
            if($jumlahSize >= $jumlahBarang) {
                $total = $jumlahSize - $jumlahBarang;
                $transaksiUpdate = Transaksi::where('id', $request->id)->update([
                    "idKodeTransaksi"=> $request->kodeTransaksi, 
                    "idProduk" => $request->idProduk, 
                    "idSize"=> $request->idSize, 
                    "hargaSatuan"=> $request->hargaSatuan, 
                    "jumlahBarang"=> $request->jumlahBarang, 
                    "diskon"=> $request->diskon ? $request->diskon : 0, 
                    "diskon_amount"=> $request->diskonAmount ? $request->diskonAmount : 0,
                    "total"=> $request->total, 
                    "note"=> $request->note && $request->note,
                ]);
                DB::table('size')->where('id','=', $request->idSize)->update([
                    "jumlah" => $total,
                ]);
            } 
            

            return response()->json([
                "status" => true,
                "message" => "update item transaksi success",
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
