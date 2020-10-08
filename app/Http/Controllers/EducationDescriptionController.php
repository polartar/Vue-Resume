<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEducationDescription;
use App\Models\EducationDescription;
use Illuminate\Http\Request;

class EducationDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEducationDescription $educationDescriptionRequest)
    {
        $validated = $educationDescriptionRequest->validated();

        try {
            $educationDescription = EducationDescription::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true', 'id' => $educationDescription->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationDescription  $educationDescription
     * @return \Illuminate\Http\Response
     */
    public function show(EducationDescription $educationDescription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationDescription  $educationDescription
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationDescription $educationDescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationDescription  $educationDescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationDescription $educationDescription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationDescription  $educationDescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationDescription $educationDescription)
    {
        //
    }
}
