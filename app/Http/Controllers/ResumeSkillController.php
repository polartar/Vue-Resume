<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeSkillRequest;
use App\Models\ResumeSkill;
use Illuminate\Http\Request;

class ResumeSkillController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResumeSkillRequest $request)
    {
        $validated = $request->validated();

        try {
            ResumeSkill::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResumeSkill $resumeSkill
     * @return \Illuminate\Http\Response
     */
    public function show(ResumeSkill $resumeSkill)
    {
        return response(['success' => 'true', 'resume' => $resumeSkill], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResumeSkill $resumeSkill
     * @return \Illuminate\Http\Response
     */
    public function edit(ResumeSkill $resumeSkill)
    {
        // No use as of yet
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResumeSkill  $resumeSkill
     * @return \Illuminate\Http\Response
     */
    public function update(StoreResumeSkillRequest $request, ResumeSkill $skill)
    {
        $validated = $request->validated();

        try {
            $skill->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResumeSkill  $resumeSkill
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResumeSkill $skill)
    {
        try {
            $skill->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
