<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisPembayaranController extends Controller
{
    //
    public function index (Request $request) {
        try {
            //code...
            $jenisPembayaran = DB::table('jenis_pembayarans')->get();
            return response()->json($jenisPembayaran);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function store(Request $request) {
        try {
            //code...
            $this->validate($request, [
                "name" => "required|string",
                "rate" => "required"
            ]);
            $create = JenisPembayaran::create([
                "name" => $request->name,
                "rate" => $request->rate,
            ]);
            return response()->json([
                "status" => true,
                "message" => "insert jenis pembayaran success",
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

    public function update (Request $request) {
        $this->validate($request, [
            "id" => "required",
            "name" => "required|string",
            "rate" => "required"
        ]);
        try {
            //code...
            $create = JenisPembayaran::where('id', '=',$request->id)->update([
                "name" => $request->name,
                "rate" => $request->rate,
            ]);
            return response()->json([
                "status" => true,
                "message" => "Update jenis pembayaran success",
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
