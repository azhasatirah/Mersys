<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use PDF;

class DocumentController extends Controller
{
    //
    public function streamModul($id){
        return view('document_viewer.pdf',['modul'=>$id]);
    }
}
