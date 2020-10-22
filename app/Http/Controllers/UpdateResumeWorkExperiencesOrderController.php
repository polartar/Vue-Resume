<?php

namespace App\Http\Controllers;

use App\Models\ResumeWorkExperience;
use Illuminate\Http\Request;

class UpdateResumeWorkExperiencesOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach ($request->input('work-experiences') as $work_experience) {
            $work_experience_record = ResumeWorkExperience::find($work_experience["id"]);
            $work_experience_record->order = $work_experience["order"];
            $work_experience_record->save();
        }

        return response(['success' => true], 204);
    }
}
