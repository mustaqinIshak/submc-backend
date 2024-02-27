<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index() {
        try {
            $getProdukquatity = DB::table('produk')->count();
            $getBrandquatity = DB::table('brand')->count();

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }
}
