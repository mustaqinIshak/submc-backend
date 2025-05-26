<?php

namespace App\Http\Controllers;

use App\Models\GambarProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Size;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
 
class ProdukController extends Controller
{
    //

    public function index (Request $request) {
        $this->validate($request, [
            "limit" => "required",
            "idBrand" => "required",
        ]);
        try {
            //code...
            if($request->idBrand === 0) {
                if($request->search) {
                    $persen = "%";
                    $key = $request->search;
      
                    $getProduk = DB::table('produk')
                    ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                    ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                    ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
                    ->leftJoin('size', 'produk.id', '=', 'size.produkId')
                    ->where('produk.name', 'like', $key . $persen)
                    ->orWhere('size.barcode', 'like', $key . $persen)
                    ->orWhere('categori.name', 'like', $key . $persen)
                    ->orWhere('sub_categori.name', 'like', $key . $persen)
                    // ->select('produk.id','produk.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                    // DB::raw("GROUP_CONCAT(size.name, ':', size.jumlah ORDER BY size.id ASC SEPARATOR ' ') as size") ,
                    // 'produk.sale as diskon', 'produk.status as statusProduk')
                    ->select('produk.id','size.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                        "size.name as name_size", "size.jumlah as quantity_size",
                        'produk.sale as diskon', 'produk.status as statusProduk')
                    // ->groupBy('produk.id','size.barcode','produk.name', "brand.name", "produk.harga",'categori.name','sub_categori.name','produk.sale', 'produk.status')
                    ->orderBy('produk.id', 'desc')
                    ->orderBy('size.id', 'asc') 
                    ->paginate($request->limit);
                    
                } else {
                    $getProduk = DB::table('produk')
                        ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                        ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                        ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
                        ->leftJoin('size', 'produk.id', '=', 'size.produkId')
                        // ->select('produk.id','produk.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                        // DB::raw("GROUP_CONCAT(size.name, ':', size.jumlah ORDER BY size.id ASC SEPARATOR ' ') as size") ,
                        // 'produk.sale as diskon', 'produk.status as statusProduk')
                        ->select('produk.id','size.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                        "size.name as name_size", "size.jumlah as quantity_size",
                        'produk.sale as diskon', 'produk.status as statusProduk')
                        // ->groupBy('produk.id','size.barcode','produk.name', "brand.name", "produk.harga",'categori.name','sub_categori.name','produk.sale', 'produk.status')
                        ->orderBy('produk.id', 'desc')
                        ->orderBy('size.id', 'asc') 
                        ->paginate($request->limit);
                }
                return response()->json([
                    "status" => true,
                    "data" => $getProduk,
                ]);
            } else {
                if($request->search) {
                    $persen = "%";
                    $key = $request->search;
      
                    $getProduk = DB::table('produk')
                    ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                    ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                    ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
                    ->leftJoin('size', 'produk.id', '=', 'size.produkId')
                    ->where('brand.id','=', $request->idBrand)
                    ->where('produk.name', 'like', $key . $persen)
                    ->orWhere('size.barcode', 'like', $key . $persen)
                    ->orwhere('categori.name', 'like', $key . $persen)
                    ->orWhere('sub_categori.name', 'like', $key . $persen)
                    // ->select('produk.id','produk.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                    // DB::raw("GROUP_CONCAT(size.name, ':', size.jumlah ORDER BY size.id ASC SEPARATOR ' ') as size") ,
                    // 'produk.sale as diskon', 'produk.status as statusProduk')
                    ->select('produk.id','size.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                        "size.name as name_size", "size.jumlah as quantity_size",
                        'produk.sale as diskon', 'produk.status as statusProduk')
                    // ->groupBy('produk.id','size.barcode','produk.name', "brand.name", "produk.harga",'categori.name','sub_categori.name','produk.sale', 'produk.status')
                    ->orderBy('produk.id', 'desc')
                    ->orderBy('size.id', 'asc') 
                    ->paginate($request->limit);
                    
                } else {
                    $getProduk = DB::table('produk')
                        ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                        ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                        ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
                        ->leftJoin('size', 'produk.id', '=', 'size.produkId')
                        ->where('brand.id','=', $request->idBrand)
                        // ->select('produk.id','size.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                        // "size.name as name_size", DB::raw("GROUP_CONCAT(size.jumlah ORDER BY size.id) as quantity_size") ,
                        // 'produk.sale as diskon', 'produk.status as statusProduk')
                        ->select('produk.id','size.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                        "size.name as name_size", "size.jumlah as quantity_size",
                        'produk.sale as diskon', 'produk.status as statusProduk')
                        // ->groupBy('produk.id','size.barcode','produk.name', "brand.name", "produk.harga",'categori.name','sub_categori.name','produk.sale', 'produk.status')
                        ->orderBy('produk.id', 'desc')
                        ->paginate($request->limit);
                }
                return response()->json([
                    "status" => true,
                    "data" => $getProduk,
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

    public function getCountProduct(Request $request) {
        
        try {
            //code...
            $getCount = DB::table('size')
            ->sum('jumlah');

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

    public function getSelected (Request $request) {
        $this->validate($request, [
            "id" => "required",
        ]);
        try {
            //code...
            $getProduk = DB::table('produk')
            ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
            ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
            ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
            ->leftJoin('size', 'produk.id', '=', 'size.produkId')
            ->where("produk.id", "=", $request->id)
            ->select('produk.*', "size.barcode",'categori.name as categoriName', 'sub_categori.name as subKategoriName', 'brand.name as brandName')
            ->first();
            

            if($getProduk) {
                $getGambarProduk = DB::table('gambar_produk')
                ->where("produkId", "=", $request->id)
                ->get()
                ;
    
                $getSize = DB::table('size')
                ->where('produkId', '=', $request->id)
                ->get();
    
                $getProduk->gambar = $getGambarProduk;
                $getProduk->sizes = $getSize;
    
                return response()->json([
                    "status" => true,
                    "data" => $getProduk,
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


    public function create (Request $request) {
        $this->validate($request, [
            "name" => "required|string|unique:produk,name",
            "harga" => "required",
            "idCategori" => "required",
            "idSubCategori" => "required",
            "idBrand" => "required",
            "deskripsi" => "required",
            "gambar"=> 'required',
            "linkShoope" => "required",
            "status"=> "required",
            "size" => "required",
            
        ]);
        $kodeName = substr($request->input("name"), 0, 3);
        $dateBarcode = time();
        $generateCodeBarcode = generateNumberBarcode($kodeName, $dateBarcode);
        try {
            //code...
                $createProduk = Produk::create([
                    "name"=> $request->input("name"),
                    "harga" => $request->input("harga"),
                    "id_categori" => $request->input("idCategori"),
                    "id_sub_categori" => $request->input("idSubCategori"),
                    "deskripsi" => $request->input("deskripsi"),
                    "color"=> $request->input("color"),
                    "type"=> $request->input("type"),
                    "jenis_bahan" => $request->input("jenisBahan"),
                    "link_shoope" => $request->input("linkShoope"),
                    "sale" => $request->input("sale"),
                    "start_sale" => !$request->input("startSale" ) ? Carbon::now() : $request->input("startSale" ),
                    "end_sale" => !$request->input("endSale" ) ? Carbon::now() : $request->input("endSale" ),
                    "status" => $request->input("status"),
                    "id_brand" => $request->input('idBrand'),
                    "jumlah_sale" => $request->input('jumlahSale')
                ]);
                $images = $request->file('gambar');
                $sizes = $request->input('size');
                if($images) {
                    foreach ($images as $image) {
                        // $path = $image->store('uploads'); // Store images in the "uploads" directory.
                        $produkId = $createProduk->id;
                        $clearedString = str_replace(' ', '', $image->getClientOriginalName());
                        $imageName = time() . '.' . $clearedString ;
                        $image->move('produkImg', $imageName);
                        $pathGambar = url('produkImg'.'/'.$imageName);
                        $insertGambar = GambarProduk::create([
                            "produkId" => $produkId,
                            "name" => $imageName,
                            "path" => $pathGambar,
                        ]);
                        
                    }
                }
                foreach ($sizes as $size) {
                    $decode = json_decode($size);
                    $insertSize =   Size::create([
                        "produkId" => $createProduk->id,
                        "barcode" => generateNumberBarcode($kodeName, $dateBarcode),
                        "name" => $decode->name,
                        "jumlah" => $decode->jumlah,
                    ]);
                }
                return response()->json([
                    "status" => true,
                    "message" => "insert produk success",
                ]);
            
            // else {
            //     return response()->json([
            //         "status" => false,
            //         "message" => "insert produk Gagal",
            //     ],400);
            //     die;
            // }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function createFromExcel(Request $request) {
        $this->validate($request, [
            "fileExcel" => "required|file|mimes:xlsx,xls|max:2048", // Validasi untuk file Excel
        ]);
    
        try {
            // Mengambil file Excel
            $file = $request->file('fileExcel');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(); // Mengubah menjadi array
    
            foreach ($sheetData as $row) {
                // Misalkan kolom dalam file Excel berdasarkan urutan:
                // 0: name, 1: harga, 2: idCategori, 3: idSubCategori,
                // 4: idBrand, 5: deskripsi, 6: linkShoope, 7: status,
                // 8: imageName (nama file gambar), 9: sizeName, 10: sizeQuantity
    
                // Validasi data yang diperlukan
                if (empty(trim($row[0])) || empty(trim($row[1])) || empty(trim($row[2])) ||
                    empty(trim($row[3])) || empty(trim($row[4])) || empty(trim($row[5])) ||
                    empty(trim($row[6])) || empty(trim($row[7]))) {
                    continue; // Lewati jika data tidak lengkap
                }
    
                // Menyimpan produk ke database
                $produk = Produk::create([
                    "name" => trim($row[0]),
                    "harga" => trim($row[1]),
                    "id_categori" => trim($row[2]),
                    "id_sub_categori" => trim($row[3]),
                    "deskripsi" => trim($row[5]),
                    "link_shoope" => trim($row[6]),
                    "status" => trim($row[7]),
                    "id_brand" => trim($row[4]),
                ]);
    
                // Menyimpan gambar ke database (jika ada)
                if (!empty(trim($row[8]))) {
                    GambarProduk::create([
                        "produkId" => $produk->id,
                        "name" => trim($row[8]),
                        "path" => url('produkImg/' . trim($row[8])), // Sesuaikan path sesuai tempat penyimpanan gambar Anda
                    ]);
                }
    
                // Menyimpan ukuran produk jika tersedia
                if (!empty(trim($row[9])) && !empty(trim($row[10]))) {
                    Size::create([
                        "produkId" => $produk->id,
                        "name" => trim($row[9]),
                        "jumlah" => intval(trim($row[10])),
                    ]);
                }
            }
    
            return response()->json([
                "status" => true,
                "message" => "Produk berhasil ditambahkan dari Excel",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request) {
        $this->validate($request, [
            "id" => "required",
            "name" => "required",
            "harga" => "required",
            "idCategori" => "required",
            "idSubCategori" => "required",
            "idBrand" => "required",
            "deskripsi" => "required",
            "linkShoope" => "required",
            "status"=> "required",
        ]);

        try {
            $getAllGambar = DB::table('gambar_produk')->where("produkId", '=', $request->id)
            ->get();
            if(count($getAllGambar) === 0) {
                return response()->json([
                    "status" => false,
                    "message" => "Gambar Produk tidak boleh kosong",
                ], 400);
                die;
            } 
            $updateProduk = Produk::where('id', '=',$request->id)
            ->update([
                "name"=> $request->input("name"),
                "harga" => $request->input("harga"),
                "id_categori" => $request->input("idCategori"),
                "id_sub_categori" => $request->input("idSubCategori"),
                "deskripsi" => $request->input("deskripsi"),
                "color"=> $request->input("color"),
                "type"=> $request->input("type"),
                "jenis_bahan" => $request->input("jenisBahan"),
                "link_shoope" => $request->input("linkShoope"),
                "sale" => $request->input("sale"),
                "start_sale" => !$request->input("startSale" ) ? Carbon::now() : $request->input("startSale" ),
                "end_sale" => !$request->input("endSale" ) ? Carbon::now() : $request->input("endSale" ),
                "status" => $request->input("status"),
                "id_brand" => $request->input('idBrand'),
                "jumlah_sale" => $request->input('jumlahSale')
            ]);

            return response()->json([
                "status" => true,
                "message" => "Update produk success",
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
            "id" => "required"
        ]);

        try {
            $findTransaksi = DB::table("transaksi")
            ->where("idProduk", $request->id)
            ->first();

            if($findTransaksi) {
                return response()->json([
                    "status" => false,
                    "message" => "Maaf produk ini mempunyai riwayat transaksi, silahkan hapus transaksi produk ini terlebih dahulu"
                ],400);
            } else {
                $getGambar = DB::table('gambar_produk')->where("produkId", '=', $request->id)
                ->get();

                $getSizes = DB::table("size")->where("produkId", "=", $request->id)
                ->get();

                if($getGambar) {
                    // $parsedUrl = parse_url($getGambar->gambar);
                    // $domain = $parsedUrl['host'];
                    // $filePath = public_path($parsedUrl['path']);
                    // error_log($filePath);
                    foreach ($getGambar as $image) {
                        $pathNameGambar = 'produkImg'.'/'.$image->name;
                        if(File::exists($pathNameGambar)) {
                            File::delete($pathNameGambar);
                        }
                        DB::table('gambar_produk')
                        ->where('id', '=', $image->id)
                        ->delete()
                        ;
                    }
                }

                if($getSizes) {
                    foreach($getSizes as $sizeItem) {
                        DB::table('size')
                        ->where('id', '=', $sizeItem->id)
                        ->delete()
                        ;
                    }
                }

                DB::table("produk")
                ->where("id", '=', $request->id)
                ->delete();

                return response()->json([
                    "status" => true,
                    "message" => "Delete produk success",
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

    public function getStokOfName (Request $request) {
        $this->validate($request, [
            "idBrand" => "required",
        ]);
        try {
            //code...
            if($request->idBrand === 0) {
                $getProduk = DB::table('produk')
                    ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                    ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                    ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
                    ->leftJoin('size', 'produk.id', '=', 'size.produkId')
                    ->select('produk.id','size.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                    "size.name as name_size", "size.jumlah as quantity_size",
                    'produk.sale as diskon')
                    // ->groupBy('produk.id','produk.barcode','produk.name', "brand.name", "produk.harga",'categori.name','sub_categori.name','produk.sale', 'produk.status')
                    ->orderBy('produk.id', 'desc')
                    ->orderBy('size.id', 'asc') 
                    ->get();
            } else {
                $getProduk = DB::table('produk')
                ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                ->leftJoin('brand', 'produk.id_brand', '=','brand.id')
                ->leftJoin('size', 'produk.id', '=', 'size.produkId')
                ->where('brand.id','=', $request->idBrand)
                ->select('produk.id','size.barcode','produk.name', 'brand.name as brand_name',"produk.harga",'categori.name as kategori','sub_categori.name as subKategori', 
                "size.name as name_size", "size.jumlah as quantity_size",
                'produk.sale as diskon')
                // ->groupBy('produk.id','produk.barcode','produk.name', "brand.name", "produk.harga",'categori.name','sub_categori.name','produk.sale', 'produk.status')
                ->orderBy('produk.id', 'desc')
                ->orderBy('size.id', 'asc') 
                ->get();
            }
            return response()->json([
                "status" => true,
                "data" => $getProduk,
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
