<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use PDF;
use Str;

class GenerateResumePdfController extends Controller
{
    public function __invoke(Request $request, Resume $resume)
    {
        $template = Str::slug($resume->resumeDesign->name, '-');
        $pdf = PDF::loadView('templates.' . $template, compact('resume'));
        if ($request->get('page')) {
            return view('templates.golden-standard', compact('resume'));
        }
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('resume.pdf');
    }
}
