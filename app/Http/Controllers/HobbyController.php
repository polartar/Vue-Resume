<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHobbyRequest;
use Exception;

class HobbyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHobbyRequest $request)
    {
        $validated = $request->validated();
        try {
            Hobby::create($validated);
        } catch (Exception $e) {
            return response(['success' => false, 'error' => $e], 500);
        }

        return response(204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hobbies  $hobbies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hobby $hobby)
    {
        try {
            $hobby->delete();
        } catch (Exception $e) {
            return response(['success' => false, 'error' => $e], 500);
        }
        
        return response(204);
    }
}
