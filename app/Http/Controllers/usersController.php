<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class usersController extends Controller
{
    public function index(){
        return view('viewhome',[
            'data' => DB::table("users")->orderBy("id")->paginate(10)
        ]);
    }

    public function insertdata(Request $request){
        $data = $request->data;
        $age = null;
        $city = null;
        $send['success'] = 1;
        $send['error'] = null;
        foreach($data as $key => $item){
            $tipe = (int)$item;
            if($tipe == 0){
                if($key == 0){
                    $name = $item;
                }else{
                    if($tipe == 0 and $age == null){
                        $name .= ' '.$item;
                    }else if($age != null){
                        if(strtoupper($item) != 'TH' && strtoupper($item) != 'THN' && strtoupper($item) != 'TAHUN'){
                            if($city == null){
                                $city = $item;
                            }else{
                                $city .= ' '.$item;
                            }
                        }
                    }
                }
            }else{
                if($key == 0){
                    $send['success'] = 0;
                    $send['error'] = 'Input Pertama Harus Nama';
                }
                $age = $item;
            }
        }
        if($age == null){
            $send['success'] = 0;
            $send['error'] = 'Umur Tidak ada';
        }
        if($city == null){
            $send['success'] = 0;
            $send['error'] = 'Kota tidak ada';
        }
        if($send['success'] != 0){
            $insertdata = [
                'name' => strtoupper($name),
                'age' => $age,
                'city' => strtoupper($city),
                'remember_token' => $request->_token
            ];
            User::Create($insertdata);
        }
        return response()->json($send);
    }
}
