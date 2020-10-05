<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeDesignsRequest;
use App\Models\Resume;
use App\Models\ResumeDesign;
use Illuminate\Http\Request;

class ResumeDesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resumeDesigns = ResumeDesign::orderBy('created_at')->get();
        return response(['success' => 'true', 'resumeDesigns' => $resumeDesigns], 200);
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
    public function store(StoreResumeDesignsRequest $request)
    {
        $validated = $request->validated();

        try {
            ResumeDesign::create($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResumeDesign  $resumeDesign
     * @return \Illuminate\Http\Response
     */
    public function show(ResumeDesign $resumeDesign)
    {
        return response(['success' => 'true', 'resumeDesign' => $resumeDesign], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResumeDesign  $resumeDesign
     * @return \Illuminate\Http\Response
     */
    public function edit(ResumeDesign $resumeDesign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResumeDesign  $resumeDesign
     * @return \Illuminate\Http\Response
     */
    public function update(StoreResumeDesignsRequest $request, ResumeDesign $resumeDesign)
    {
        $validated = $request->validated();

        try {
            $resumeDesign->update($validated);
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }

        return response(['success' => 'true'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResumeDesign  $resumeDesign
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResumeDesign $resumeDesign)
    {
        try {
            $resumeDesign->delete();
        } catch (\Exception $e) {
            return response(['success' => 'false', 'message' => $e], 400);
        }
        return response(['success' => 'true'], 204);
    }
}
