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
        /* Ideas for page breaks
            Lines have between 1 and 85 characters, with a common minimum being 80 characters

            New section headers use about 3 lines total
            This means that at the minimum, each work experience will add 4 lines
            
            We can have a total of 19 lines on the first page

            A count of the number of characters in each work/education description field / 80 should give us the number of lines

            Based on this information, we can keep a count of how many lines are taken, and if that exceeds the max bound, 
                then we know where to put a page break. We then reset the count and continue on until the PDF is rendered.
                
            I'm thinking an array of indexes (work experiences AND educations) and after each index listed we put a page break
        */
        $template = Str::slug($resume->resumeDesign->name, '-');
        $pdf = PDF::loadView('templates.' . $template, compact('resume'));

        if ($request->get('page')) {
            // dump($template);
            return view('templates.' . $template, compact('resume'));
        }
        $pdf->setPaper('letter', 'portrait');

        if ($request->get('preview')) {
            return $pdf->stream();
        }

        return $pdf->download('resume.pdf');
    }
}
