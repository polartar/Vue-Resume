<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeWorkExperienceRequest;
use App\Http\Requests\UpdateResumeWorkExperienceRequest;
use App\Models\ResumeWorkExperience;
use Illuminate\Http\Request;

class ResumeWorkExperienceController extends Controller
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
    public function store(StoreResumeWorkExperienceRequest $request)
    {
        $validated = $request->validated();

        try {
            $resumeWorkExperience = ResumeWorkExperience::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true', 'id' => $resumeWorkExperience->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResumeWorkExperience  $resumeWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function show(ResumeWorkExperience $resumeWorkExperience)
    {
        return response(['success' => 'true', 'resume' => $resumeWorkExperience], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResumeWorkExperience  $resumeWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function edit(ResumeWorkExperience $resumeWorkExperience)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResumeWorkExperience  $resumeWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResumeWorkExperienceRequest $request, ResumeWorkExperience $resumeWorkExperience)
    {
        $validated = $request->validated();

        try {
            $resumeWorkExperience->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResumeWorkExperience  $resumeWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResumeWorkExperience $resumeWorkExperience)
    {
        try {
            $resumeWorkExperience->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
