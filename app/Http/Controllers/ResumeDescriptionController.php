<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeDescriptionRequest;
use App\Models\ResumeDescription;
use Illuminate\Http\Request;

class ResumeDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // No use
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No use
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResumeDescriptionRequest $request)
    {
        $validated = $request->validated();

        try {
            $resumeDescription = ResumeDescription::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true', 'id' => $resumeDescription->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResumeDescription  $resumeDescription
     * @return \Illuminate\Http\Response
     */
    public function show(ResumeDescription $resumeDescription)
    {
        return response(['success'=>'true', 'resumeDescription'=>$resumeDescription], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResumeDescription  $resumeDescription
     * @return \Illuminate\Http\Response
     */
    public function edit(ResumeDescription $resumeDescription)
    {
        // no use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResumeDescription  $resumeDescription
     * @return \Illuminate\Http\Response
     */
    public function update(StoreResumeDescriptionRequest $request, ResumeDescription $resumeDescription)
    {
        $validated = $request->validated();

        try {
            $resumeDescription->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResumeDescription  $resumeDescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResumeDescription $resumeDescription)
    {
        try {
            $resumeDescription->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
