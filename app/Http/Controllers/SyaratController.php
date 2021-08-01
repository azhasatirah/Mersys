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

    public function update(Request $request){
        //dd($request);
        $File = $request->file('file');
        $FormatFile = $File->getClientOriginalExtension();
        if($FormatFile != 'pdf'){
            return redirect()->back()->withErrors(['msg'=>'Format file harus pdf']);
        }
        $NameFile = 'sk060521022054.sspdf';
        if(file_exists('program_studi/modul/'.$NameFile)){

            unlink('program_studi/modul/'.$NameFile);
        }
        $File->move(public_path('program_studi/modul'),$NameFile);
        return redirect()->back()->withErrors(['msg'=>'Syarat dan Ketentuan Berhasil Diganti']);
    }

    //json

}
