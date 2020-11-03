<?php

namespace App\Http\Controllers;

use App\Models\ResumeSummary;
use Illuminate\Http\Request;

class UpdateResumeSummaryOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach ($request->input('summaries') as $summary) {
            $summary_record = ResumeSummary::find($summary["id"]);
            $summary_record->order = $summary["order"];
            $summary_record->save();
        }

        return response(['success' => true], 204);
    }
}
