<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function getAll(Request $request) {
        $this->validate($request, [
            "limit" => "required",
        ]);
        try {
            //code...
            if($request->search) {
                $persen = "%";
                $key = $request->search;
                $user = DB::table('users')
                ->leftJoin('roles_user', 'users.id_role', '=', 'roles_user.id')
                ->where('users.name', 'like', $key . $persen)
                ->orWhere('users.username', 'like', $key . $persen)
                ->orWhere('roles_user.name', 'like', $key . $persen)
                ->select('users.id','users.name','users.username','roles_user.name as name_role')
                ->paginate($request->limit);
            } else {
                $user = DB::table('users')
                ->leftJoin('roles_user', 'users.id_role', '=', 'roles_user.id')
                ->select('users.id','users.name','users.username','roles_user.name as name_role')
                ->paginate($request->limit);
            }

            return response()->json([
                "status" => true,
                "data" => $user,
            ]);

        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function getSelected(Request $request) {
        $this->validate($request, [
            "id" => "required",
        ]);
        try {
            //code...
            $user = DB::table('users')
            ->join('roles_user', 'users.id_role', '=', 'roles_user.id')
            ->where('users.id','=', $request->id)
            ->select('users.id','users.name','users.username','users.id_role','roles_user.name as name_role')
            ->first()
            ;
            return response()->json([
                "status" => true,
                "data" => $user,
            ]);

        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function store(Request $request) {
        $this->validate($request, [
            "name" => "required",
            "username" => "required|string|unique:users,username",
            "password" => "required",
        ]);

        try {
            //code...
            $user = User::create([
                "name" => $request->name,
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "id_role" => $request->id_role
            ]);

            if($user) {
                return response()->json([
                    "status" => true,
                    "message" => "user add success"
                ]);
            }
        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function edit(Request $request) {
        $this->validate($request, [
            "id" => "required",
            "name" => "required",
            "username" => "required|string",
            "id_role" => "required",
        ]);

        try {
            //code...
            if($request->password) {
                $edit = User::whereId($request->id)->update([
                    "name" => $request->name,
                    "username" =>$request->username,
                    "password" => Hash::make($request->password),
                    "id_role" => $request->id_role
                ]);
                
                if($edit) {
                    return response()->json([
                        "status" => true,
                        "message" => "edit user success",
                    ]);
                }
            } else {
                $edit = User::whereId($request->id)->update([
                    "name" => $request->name,
                    "username" =>$request->username,
                    "id_role" => $request->id_role
                ]);
                
                if($edit) {
                    return response()->json([
                        "status" => true,
                        "message" => "edit user success",
                    ]);
                }
            }
        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

    public function delete(Request $request) {
        $this->validate($request, [
            "id" => "required",
        ]);

        try {
            //code...
            $id = $request->id;
            $user = User::whereId($id)->delete();

            return response()->json([
                "status" => true,
                "data" => $user,
            ]);

        } catch (\Exception $e) {
            //throw $th;
            // echo $e->getMessage();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ],400);
            die;
        }
    }

}
