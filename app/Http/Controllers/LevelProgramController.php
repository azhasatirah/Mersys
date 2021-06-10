<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelProgram;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;

class LevelProgramController extends Controller
{
        public function index(){
            return view('karyawan.master.levelprogram');
        }
        public function create(){
            return view('karyawan.master.level program.create');
        }
        public function store(Request $request){
           // dd(Carbon::now());
            $Data = array(
                'KodeLevel'=>str_replace('-','',str::uuid()),
                'NamaLevel'=>$request->level,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'UserAdd'=>session()->get('Username'),
                'UserUpd'=>session()->get('Username'),
                'Status'=>'OPN'
            );
            $status = LevelProgram::storeLevelProgram($Data);
            return response()->json($status);
        }
        public function edit($id){
            $LevelProgram = LevelProgram::getDetailLevelProgram($id);
            return response()->json($LevelProgram['LevelProgram']);
        }
        public function update(Request $request){
            $Data = array(
                'NamaLevel'=>$request->level,
                'updated_at'=>Carbon::now(),
                'UserUpd'=>session()->get('Username'),
            );
            $status = LevelProgram::updateLevelProgram($Data,$request->id);
            return response()->json($status);
        }
        public function delete($Kode){
            $Pesan = LevelProgram::deleteLevelProgram($Kode);
            return response()->json($Pesan);
        } 
        public function getData(){
            $LevelProgram = LevelProgram::getAllLevelProgram();
            return response()->json($LevelProgram);
        } 
}
