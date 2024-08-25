<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Size;
use App\Models\TransaksinDetail;
use App\Models\Transaksi;
use Illuminate\Http\Request;
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

    public function searchProduk(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $results = [];
            $products = DB::table('produk')->where('name', 'like', "%{$keyword}%")
                                ->orWhere('barcode', $keyword)
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
        try {
            $products = $request->input('produks'); // Array produk dengan id dan quantity

            $transaction = new Transaksi();
            $transaction->idKodeTransaksi = Str::uuid();
            $transaction->total = 0; // Awal total amount
            $transaction->save();
    
            $totalAmount = 0;
    
            foreach ($products as $productData) {
                $product = Produk::find($productData['id']);
                $size = Size::find($productData['sizeid']);
                if ($product->stock < $productData['quantity']) {
                    return response()->json(['message' => 'Stok tidak mencukupi untuk produk ' . $product->name], 400);
                }
    
                $product->stock -= $productData['quantity'];
                $product->save();
    
                $detail = new TransactionDetail();
                $detail->transaction_id = $transaction->id;
                $detail->product_id = $product->id;
                $detail->quantity = $productData['quantity'];
                $detail->price = $product->price;
                $detail->save();
    
                $totalAmount += $product->price * $productData['quantity'];
            }
    
            $transaction->total_amount = $totalAmount;
            $transaction->save();
    
            return response()->json($transaction->load('details'), 201);
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
