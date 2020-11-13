<?php

namespace App\Http\Controllers;

use App\Models\ResumeSkill;
use Illuminate\Http\Request;

class UpdateSkillOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach ($request->input('skills') as $skill) {
            $skill_record = ResumeSkill::find($skill["id"]);
            $skill_record->sort_order = $skill["sort_order"];
            $skill_record->save();
        }

        return response(['success' => true], 204);
    }
}
