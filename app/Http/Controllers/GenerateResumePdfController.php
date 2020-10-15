<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use PDF;

class GenerateResumePdfController extends Controller
{
    public function __invoke(Resume $resume)
    {
        $pdf = PDF::loadView('templates.golden-standard', compact('resume'));   
        return $pdf->download('resume.pdf');
    }
}
