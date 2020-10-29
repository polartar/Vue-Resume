<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hobby;

class UpdateHobbyOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach ($request->input('hobbies') as $hobby) {
            $hobby_record = Hobby::find($hobby["id"]);
            $hobby_record->order = $hobby["order"];
            $hobby_record->save();
        }

        return response(['success' => true], 204);
    }
}
