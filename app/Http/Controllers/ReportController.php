<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function index(Request $request) {
        $this->validate($request, [
            "limit" => "required",
            "tanggalAwal" => "required",
            "tanggalAkhir" => "required",
            "idBrand" => "required",
            "idMetodePembayaran" => "required",
        ]);

        try {
            //code...
            //transaksis join produk dan size
            //proudk join brand 
            $tanggalAwal = $request->tanggalAwal;
            $tanggalAkhir = $request->tanggalAkhir;
            error_log($request->idMetodePembayaran);
            // dd($tanggalAwal);
            if($request->typeFile === 'excel') {
                if($request->idMetodePembayaran === 0) {
                    $getLaporan = DB::table('transaksis')
                    ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                    ->leftJoin('size', 'transaksis.idSize','=','size.id')
                    ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                    ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                    ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                    ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                    ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                    ->select('transaksis.created_at as tanggal',
                    'transaksis.id', 
                    'kode_transaksis.kode',
                    'size.barcode',
                    'produk.name',
                    'size.name as size', 
                    'categori.name as kategori',
                    'sub_categori.name as subKategori',
                    'produk.harga',
                    'transaksis.jumlahBarang', 
                    'transaksis.diskon', 
                    'transaksis.total', 
                    'size.jumlah as sisaStok',
                    'jenis_pembayarans.name as metodePembayaran',
                    'transaksis.note')
                    ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                    ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                    ->where('produk.id_brand', '=', $request->idBrand)
                    ->get()
                    ;
    
                    return response()->json([
                        "status" => true,
                        "data" => $getLaporan,
                    ]);
                } else {
                    $getLaporan = DB::table('transaksis')
                    ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                    ->leftJoin('size', 'transaksis.idSize','=','size.id')
                    ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                    ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                    ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                    ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                    ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                    ->select('transaksis.created_at as tanggal',
                    'transaksis.id', 
                    'kode_transaksis.kode',
                    'size.barcode',
                    'produk.name',
                    'size.name as size', 
                    'categori.name as kategori',
                    'sub_categori.name as subKategori',
                    'produk.harga',
                    'transaksis.jumlahBarang', 
                    'transaksis.diskon', 
                    'transaksis.total', 
                    'size.jumlah as sisaStok',
                    'jenis_pembayarans.name as metodePembayaran',
                    'transaksis.note')
                    ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                    ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                    ->where('produk.id_brand', '=', $request->idBrand)
                    ->where('kode_transaksis.idJenisPembayaran', '=', $request->idMetodePembayaran)
                    ->get()
                    ;
    
                    return response()->json([
                        "status" => true,
                        "data" => $getLaporan,
                    ]);
                }
               
            } else if($request->idMetodePembayaran == 0) {
                $getLaporan = DB::table('transaksis')
                ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                ->leftJoin('size', 'transaksis.idSize','=','size.id')
                ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                ->select('transaksis.created_at as tanggal',
                'transaksis.id', 
                'kode_transaksis.kode',
                'size.barcode',
                'produk.name',
                'size.name as size', 
                'categori.name as kategori',
                'sub_categori.name as subKategori',
                'produk.harga',
                'transaksis.jumlahBarang', 
                'transaksis.diskon', 
                'transaksis.total', 
                'size.jumlah as sisaStok',
                'jenis_pembayarans.name as metodePembayaran',
                'transaksis.note')
                ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                ->where('produk.id_brand', '=', $request->idBrand)
                ->paginate($request->limit)
                ;

                return response()->json([
                    "status" => true,
                    "data" => $getLaporan,
                ]);
            } else {
                $getLaporan = DB::table('transaksis')
                ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                ->leftJoin('size', 'transaksis.idSize','=','size.id')
                ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                ->select('transaksis.created_at as tanggal',
                'transaksis.id', 
                'kode_transaksis.kode',
                'size.barcode',
                'produk.name',
                'size.name as size', 
                'categori.name as kategori',
                'sub_categori.name as subKategori',
                'produk.harga',
                'transaksis.jumlahBarang', 
                'transaksis.diskon', 
                'transaksis.total', 
                'size.jumlah as sisaStok',
                'jenis_pembayarans.name as metodePembayaran',
                'transaksis.note')
                ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                ->where('produk.id_brand', '=', $request->idBrand)
                ->where('kode_transaksis.idJenisPembayaran', '=', $request->idMetodePembayaran)
                ->paginate($request->limit)
                ;

                return response()->json([
                    "status" => true,
                    "data" => $getLaporan,
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

    public function report(Request $request) {
        $this->validate($request, [
            "tanggalAwal" => "required",
            "tanggalAkhir" => "required",
            "idBrand" => "required",
            "idMetodePembayaran" => "required",
        ]);

        try {
            //code...
            //transaksis join produk dan size
            //proudk join brand 
            $tanggalAwal = $request->tanggalAwal;
            $tanggalAkhir = $request->tanggalAkhir;
            error_log($request->idMetodePembayaran);
            // dd($tanggalAwal);
            if($request->typeFile === 'excel') {
                if($request->idMetodePembayaran === 0) {
                    $getLaporan = DB::table('transaksis')
                    ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                    ->leftJoin('size', 'transaksis.idSize','=','size.id')
                    ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                    ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                    ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                    ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                    ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                    ->select('transaksis.created_at as tanggal',
                    'transaksis.id', 
                    'kode_transaksis.kode',
                    'size.barcode',
                    'produk.name',
                    'size.name as size', 
                    'categori.name as kategori',
                    'sub_categori.name as subKategori',
                    'produk.harga',
                    'transaksis.jumlahBarang', 
                    'transaksis.diskon', 
                    'transaksis.total', 
                    'size.jumlah as sisaStok',
                    'jenis_pembayarans.name as metodePembayaran',
                    'transaksis.note')
                    ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                    ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                    ->where('produk.id_brand', '=', $request->idBrand)
                    ->get()
                    ;
    
                    return response()->json([
                        "status" => true,
                        "data" => $getLaporan,
                    ]);
                } else {
                    $getLaporan = DB::table('transaksis')
                    ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                    ->leftJoin('size', 'transaksis.idSize','=','size.id')
                    ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                    ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                    ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                    ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                    ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                    ->select('transaksis.created_at as tanggal',
                    'transaksis.id', 
                    'kode_transaksis.kode',
                    'size.barcode',
                    'produk.name',
                    'size.name as size', 
                    'categori.name as kategori',
                    'sub_categori.name as subKategori',
                    'produk.harga',
                    'transaksis.jumlahBarang', 
                    'transaksis.diskon', 
                    'transaksis.total', 
                    'size.jumlah as sisaStok',
                    'jenis_pembayarans.name as metodePembayaran',
                    'transaksis.note')
                    ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                    ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                    ->where('produk.id_brand', '=', $request->idBrand)
                    ->where('kode_transaksis.idJenisPembayaran', '=', $request->idMetodePembayaran)
                    ->get()
                    ;
    
                    return response()->json([
                        "status" => true,
                        "data" => $getLaporan,
                    ]);
                }
               
            } else if($request->idMetodePembayaran == 0) {
                $getLaporan = DB::table('transaksis')
                ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                ->leftJoin('size', 'transaksis.idSize','=','size.id')
                ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                ->select('transaksis.created_at as tanggal',
                'transaksis.id', 
                'kode_transaksis.kode',
                'size.barcode',
                'produk.name',
                'size.name as size', 
                'categori.name as kategori',
                'sub_categori.name as subKategori',
                'produk.harga',
                'transaksis.jumlahBarang', 
                'transaksis.diskon', 
                'transaksis.total', 
                'size.jumlah as sisaStok',
                'jenis_pembayarans.name as metodePembayaran',
                'transaksis.note')
                ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                ->where('produk.id_brand', '=', $request->idBrand)
                ->paginate($request->limit)
                ;

                return response()->json([
                    "status" => true,
                    "data" => $getLaporan,
                ]);
            } else {
                $getLaporan = DB::table('transaksis')
                ->leftJoin('produk', 'transaksis.idProduk', '=', 'produk.id')
                ->leftJoin('size', 'transaksis.idSize','=','size.id')
                ->leftJoin('brand', 'produk.id_brand', '=', 'brand.id')
                ->leftJoin('categori', 'produk.id_categori', '=', 'categori.id')
                ->leftJoin('sub_categori', 'produk.id_sub_categori', '=', 'sub_categori.id')
                ->leftJoin('kode_transaksis', 'transaksis.idKodeTransaksi','=','kode_transaksis.id')
                ->leftJoin('jenis_pembayarans', 'kode_transaksis.idJenisPembayaran', '=', 'jenis_pembayarans.id')
                ->select('transaksis.created_at as tanggal',
                'transaksis.id', 
                'kode_transaksis.kode',
                'size.barcode',
                'produk.name',
                'size.name as size', 
                'categori.name as kategori',
                'sub_categori.name as subKategori',
                'produk.harga',
                'transaksis.jumlahBarang', 
                'transaksis.diskon', 
                'transaksis.total', 
                'size.jumlah as sisaStok',
                'jenis_pembayarans.name as metodePembayaran',
                'transaksis.note')
                ->whereDate('transaksis.created_at','>=',$tanggalAwal)
                ->whereDate('transaksis.created_at','<=',$tanggalAkhir)
                ->where('produk.id_brand', '=', $request->idBrand)
                ->where('kode_transaksis.idJenisPembayaran', '=', $request->idMetodePembayaran)
                ->paginate($request->limit)
                ;

                return response()->json([
                    "status" => true,
                    "data" => $getLaporan,
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
}
