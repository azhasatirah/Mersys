<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class GformsRespondent extends Controller
{
    //
    public function store(Request $request){
        $data = array(
            'Email'=>$request->email,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
  //      return response()->json($request);
        DB::table('gforms_respondent')->insert($data);
    }
}
