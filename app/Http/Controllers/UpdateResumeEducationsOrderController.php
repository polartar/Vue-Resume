<?php

namespace App\Http\Controllers;

use App\Models\ResumeEducation;
use Illuminate\Http\Request;

class UpdateResumeEducationsOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach ($request->input('educations') as $education) {
            $education_record = ResumeEducation::find($education["id"]);
            $education_record->order = $education["order"];
            $education_record->save();
        }

        return response(['success' => true], 204);
    }
}
