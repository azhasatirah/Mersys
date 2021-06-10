<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use DB;

class SyaratController extends Controller
{
    public function index(){
        return view('karyawan.syarat');
    }

    public function store(Request $request){
        $File = $request->file('file');
        $FormatFile = $File->getClientOriginalExtension();
        $NameFile = 'sk'.date('dmyhis').'.'.$FormatFile;
        $File->move(public_path('program_studi/modul'),$NameFile);
        $Data = array(
            'Content'=>$request->syarat,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
        );
        DB::table('syarat_ketentuan')->insert($Data);
        return response()->json('berhasil');
    }
    public function edit($id){
        $Data = DB::table('syarat_ketentuan')->where('IDSyarat',$id)->get();
        return response()->json($Data);
    }
    public function update(Request $request){
        //dd($request);
        $File = $request->file('file');
        $FormatFile = $File->getClientOriginalExtension();
        if($FormatFile != 'pdf'){
            return redirect()->back()->withErrors(['msg'=>'Gunakan format file pdf']);
        }
        $NameFile = 'sk'.date('dmyhis');
        $OldSK = DB::table('syarat_ketentuan')
        ->where('IDSyarat',$request->idsyarat)->get();
        unlink('program_studi/modul/'.$OldSK[0]->Content);
        $File->move(public_path('program_studi/modul'),$NameFile.'.sspdf');
        $Data = array(
            'Content'=>$NameFile,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
       DB::table('syarat_ketentuan')->where('IDSyarat',$request->idsyarat)
       ->update($Data);
        return redirect()->back()->withErrors(['msg'=>'Syarat dan Ketentuan Berhasil Diganti']);
    }

    //json

    public function getData(){
        $Data = DB::table('syarat_ketentuan')->get();
        return response()->json($Data);
    }
}
