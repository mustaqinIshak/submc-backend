<?php

namespace App\Http\Controllers;

use App\Models\ProfileCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileCompanyController extends Controller
{
    //
    public function index() {
        try {
            //code...
            $getProfileCompany=ProfileCompany::first();

            if($getProfileCompany) {
                return response()->json([
                    "status" => true,
                    "data" => $getProfileCompany,
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "data" => $getProfileCompany,
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
    public function update(Request $request) {
        $this->validate($request, [
            "id"=> "required",
            "name" => "required",
            "alamat" => "required",
            "nomorHp" => "required",
            "aboutUs" => "required",
        ]);
        try {
            //code...
            DB::table("profile_company")->where('id', $request->id)->update([
                "name" => $request->name,
                "alamat" => $request->alamat,
                "nomor_hp" => $request->nomorHp,
                "instagram" => $request->instagam,
                "twitter" => $request->twitter,
                "facebook" => $request->facebook,
                "youtube" => $request->youtube,
                "about_us" => $request->aboutUs,
            ]);

            return response()->json([
                "status" => true,
                "message" => "Update profil company berhasil",
            ]);
        } catch (\Exception $e) {
            //throw $th;
            error_log($e);
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }
}
