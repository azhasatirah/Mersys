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
    public function getData($id){
        $gr = DB::table('gforms_respondent')
        ->where('IDResponse',$id)
        ->get();
        $res = count($gr)>0;
        return response()->json($res);
    }
    public function store(Request $request){
        $data = array(
            'IDResponse'=>$request->idresponse,
            'KodeKursus'=>$request->kodekursus,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        try{
            DB::table('gforms_respondent')->insert($data);
            return response()->json(true);
        }catch(Exception $e){
            return response()->json(false);
        }
    }
    public function update(Request $request){
        $data = array(
            'KodeKursus'=>$request->kodekursus,
            'updated_at'=>Carbon::now(),
        );
        try{
            DB::table('gforms_respondent')->where('IDResponse',$request->idresponse)->update($data);
            return response()->json(true);
        }catch(Exception $e){
            return response()->json(false);
        }
    }
}
