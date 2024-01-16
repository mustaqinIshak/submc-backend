<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BannerHomeController extends Controller
{
    //
    public function index(Request $request) {
        try {
            //code...
            $getSubBannerHome = DB::table('banner_home')
            ->get();
            return response()->json([
                "status" => true,
                "data" => $getSubBannerHome
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

    public function create(Request $request) {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        try {
            //code...
            //upload foto
            
            $countData = DB::table('banner_home')->count();
            error_log($countData);
            if ($request->hasFile('image')) {
                if($countData < 5) {
                    // $file = $request->gambar->file('gambar');
                    // error_log($file);
                    // $name = time().$file->getClientOriginalName(); //setting nama yang ganti masuk
                    $image = $request->file('image');
                    $clearedString = str_replace(' ', '', $image->getClientOriginalName());
                    $imageName = time() . '.' . $clearedString ;
                    $image->move('banner', $imageName);
                    $gambar = url('banner'.'/'.$imageName);
                    $createdAt = Carbon::now();
                    if($request->link) {
                        $createBannerHome = DB::table('banner_home')
                        ->insert([
                            "gambar" => $gambar,
                            "link" => $request->link,
                            "created_at" => $createdAt,
                            "updated_at" => $createdAt
                        ])
                        ;
                    } else {
                        $createBannerHome = DB::table('banner_home')
                        ->insert([
                            "gambar" => $gambar,
                            "created_at" => $createdAt,
                            "updated_at" => $createdAt
                        ])
                        ;
                    }
                    return response()->json([
                        "status" => true,
                        "message" => "insert banner home success",
                    ]);
                } else {
                    return response()->json([
                        "status" => false,
                        "message" => "jumlah banner home sudah mencapai batas",
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Mohon Untuk Memasukkan Gambar Terlebih Dahulu",
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

    public function delete(Request $request) {
        $this->validate($request, [
            "id" => 'required'
        ]);
        try {
            //code...
            $getSubBannerHome = DB::table('banner_home')
            ->where("id", '=', $request->id)
            ->first();
            if($getSubBannerHome) {
                $parsedUrl = parse_url($getSubBannerHome->gambar);
                $domain = $parsedUrl['host'];
                $filePath = public_path($parsedUrl['path']);
                error_log($filePath);
                if(File::exists($filePath)) {
                    File::delete($filePath);
                    DB::table('banner_home')
                    ->where('id', '=', $request->id)
                    ->delete()
                    ;
                    return response()->json([
                        "status" => true,
                        "message" => "Delete banner home success",
                    ]);
                } else {
                    return response()->json([
                        "status" => false,
                        "message" => "Banner home yang anda ingin hapus tidak ditemukan",
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Id banner home tidak di temukan",
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
