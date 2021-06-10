<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use App\Models\Aktifasi;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function absen(Request $request){
        DB::table('absen')->insert([
            'IDJadwal'=>$request->idjadwal,
            'Absen'=>'masuk',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
        ]);
       return response()->json('oke');
    }
}
