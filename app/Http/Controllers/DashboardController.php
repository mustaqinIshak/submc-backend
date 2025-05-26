<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index() {
        try {
            $getProdukquantity = DB::table('produk')->count();
            $getBrandquantity = DB::table('brand')->count();

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function chart(Request $request) {
        $this->validate($request, [
            "period" => "required",
        ]);
        try {
            $period = $request->period;
            if ($period == 'day') {
                $data = DB::table('transaksis')
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
                    ->groupBy('date')
                    ->get();
            } elseif ($period == 'month') {
                $data = DB::table('transaksis')
                    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as total'))
                    ->groupBy('month')
                    ->get();
            } else {
                $data = DB::table('transaksis')
                    ->select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total) as total'))
                    ->groupBy('year')
                    ->get();
            }
            return response()->json([
                "status" => true,
                "data" => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }
}
