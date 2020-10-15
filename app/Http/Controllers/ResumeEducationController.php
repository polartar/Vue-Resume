<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeEducationRequest;
use App\Models\ResumeEducation;
use Illuminate\Http\Request;

class ResumeEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // No use as of yet
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No use as of yet
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResumeEducationRequest $request)
    {
        $validated = $request->validated();

        try {
            $resumeEducation = ResumeEducation::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true', 'id' => $resumeEducation->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResumeEducation  $resumeEducation
     * @return \Illuminate\Http\Response
     */
    public function show(ResumeEducation $resumeEducation)
    {
        return response(['success' => 'true', 'resume' => $resumeEducation], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResumeEducation  $resumeEducation
     * @return \Illuminate\Http\Response
     */
    public function edit(ResumeEducation $resumeEducation)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResumeEducation  $resumeEducation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreResumeEducationRequest $request, ResumeEducation $resumeEducation)
    {
        $validated = $request->validated();

        try {
            $resumeEducation->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResumeEducation  $resumeEducation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResumeEducation $resumeEducation)
    {
        try {
            $resumeEducation->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
