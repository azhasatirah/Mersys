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
    public function getData(){
        $gr = DB::table('gforms_respondent')->get();
        $gr = array_map(function($g){
            return $g->Email;
        },$gr->toArray());
        return response()->json($gr);
    }
    public function store(Request $request){
        $data = array(
            'Email'=>$request->email,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
  //      return response()->json($request);
        try{
            DB::table('gforms_respondent')->insert($data);
            return response()->json(true);
        }catch(Exception $e){
            return response()->json(false);
        }
    }
}
