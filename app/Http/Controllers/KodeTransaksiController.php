<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KodeTransaksi;

class KodeTransaksiController extends Controller
{
    //
    function index(Request $request) {
        $this->validate($request, [
            "limit" => "required"
        ]);
        try {
            //code...
            if($request->search) {
                $persen = "%";
                $key = $request->search;
                $getAllKodeTransaksi = DB::table('kode_transaksis')
                ->leftJoin('transaksi', 'transaksi.idKodeTransaksi', '=', 'kode_transaksis.id')
                ->select('kode_transaksis.*',DB::raw("COUNT(transaksi.id) as 'jumlah_item'"),)
                ->groupBy('kode_transaksis.id')
                ->orderBy('kode_transaksis.id', 'desc')
                ->where('kode_transaksis.kode', 'like', $key . $persen)
                ->paginate($request->limit);
            } else {
                $getAllKodeTransaksi = DB::table('kode_transaksis')
                ->leftJoin('transaksi', 'transaksi.idKodeTransaksi', '=', 'kode_transaksis.id')
                ->select('kode_transaksis.*',DB::raw("COUNT(transaksi.id) as 'jumlah_item'"),)
                ->groupBy('kode_transaksis.id')
                ->orderBy('kode_transaksis.id', 'desc')
                ->paginate($request->limit);
            }
          
            return response()->json([
                "status" => true,
                "data" => $getAllKodeTransaksi,
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

    function create(Request $request) {
        $this->validate($request, [
            "idOutlet" => "required"
        ]);
        $me = auth()->user();
        try{
            $kodeTransaksi = new KodeTransaksi();
            $kodeTransaksi->kode = KodeTransaksi::generateTransactionCode();
            $kodeTransaksi->idUser = $me->id;
            $kodeTransaksi->id_outlet = $request->idOutlet;
            $kodeTransaksi->amount = 0;
            $kodeTransaksi->save();

            return response()->json([
                "status" => true,
                "data" => $kodeTransaksi,
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
        
        $this->validate($request, [
            "id" => "required",
        ]);
        try {
            //code...
           
            DB::table('kode_transaksi')
            ->where('id', '=', $request->id)
            ->update([
                'note' => $request->note && $request->note,
                'idTax' => $request->idTax ? $request->idTax : 0,
                'amount' => $request->amount,
                'status' => $request->status,
                'd_outlet' => $request->id_outlet 
            ]);
            return response()->json([
                "status" => true,
                "message" => "kode transaksi berhasil di update"
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
