<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use PDF;

class GenerateResumePdfController extends Controller
{
    public function __invoke(Resume $resume)
    {
        dd($resume);
        //return view('templates.golden-standard');
        $pdf = PDF::loadView('templates.golden-standard');
        
        return $pdf->download('resume.pdf');
    }
}
