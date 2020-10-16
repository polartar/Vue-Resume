<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use PDF;

class GenerateResumePdfController extends Controller
{
    public function __invoke(Resume $resume)
    {
        //dd($resume);
        $data = ['resume' => $resume];
        $pdf = PDF::loadView('templates.golden-standard', $data);   
        return $pdf->download('resume.pdf');
    }
}
